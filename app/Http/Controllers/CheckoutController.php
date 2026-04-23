<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    
    public function index(){
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Belanja Kosong!');
        }

        $subtotal = array_sum(array_map(fn($item) =>  $item['price'] * $item['quantity'], $cart));
        $shippingCost = 15000;
        $total = $subtotal + $shippingCost;

        return view('checkout.index', compact('cart', 'subtotal', 'shippingCost', 'total'));
    }

    public function process(Request $request){

    $request->validate([
        'shipping_name' => 'required|string|max:255',
        'shipping_phone' => 'required|string|max:20',
        'shipping_address' => 'required|string',
        'shipping_city' => 'required|string|max:100',
        'shipping_postal_code' => 'required|string|max:10',
    ]);

    $cart = session()->get('cart', []);
    if (empty($cart)) {
        return redirect()->route('cart.index')->with('error', 'Keranjang Belanja Kosong!');
    }
    
    $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));
    $shippingCost = 15000;
    $total = $subtotal + $shippingCost;

    DB::beginTransaction();

    try {
        $order = Order::create([
            'user_id' => Auth::id(),
            'order_number' => Order::generateOrderNumber(),
            'subtotal' => $subtotal,
            'shipping_cost' => $shippingCost,
            'total' => $total,
            'status' => 'pending',
            'shipping_name' => $request->shipping_name,
            'shipping_phone' => $request->shipping_phone,
            'shipping_address' => $request->shipping_address,
            'shipping_city' => $request->shipping_city,
            'shipping_postal_code' => $request->shipping_postal_code,
            'notes' => $request->notes,
        ]);

        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'size' => $item['size'],
                'color' => $item['color'],
                'price' => $item['price'],
                'subtotal' => $item['price'] * $item['quantity'],
            ]);
        }

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        $itemDetails = [];
        foreach ($cart as $item){
            $itemDetails[] = [
                'id' => (string) $item['product_id'],
                'price' => (int) $item['price'],
                'quantity' => $item['quantity'],
                'name' => substr($item['name'] . '(' . $item['size'] . '/' . $item['color'] . ')', 0, 50),
            ];
        }
        $itemDetails[] = [
            'id' => 'SHIPPING',
            'price' => (int) $shippingCost,
            'quantity' => 1,
            'name' => 'Ongkos Kirim',
        ];

        $transactionDetails = [
            'order_id' => $order->order_number,
            'gross_amount' => (int) $total,
        ];

        $custumerDetails = [
            'first_name' => Auth::user()->name,
            'email' => Auth::user()->email,
            'phone' => $request->shipping_phone,
            'billing_address' => [
                'first_name' => $request->shipping_name,
                'phone' => $request->shipping_phone,
                'address' => $request->shipping_address,
                'city' => $request->shipping_city,
                'postal_code' => $request->shipping_postal_code,
                'country_code' => 'IDN',
            ],
            'shipping_address' => [
                'first_name' => $request->shipping_name,
                'phone' => $request->shipping_phone,
                'address' => $request->shipping_address,
                'city' => $request->shipping_city,
                'postal_code' => $request->shipping_postal_code,
                'country_code' => 'IDN',
            ],
        ];
        $params = [
            'transaction_details' => $transactionDetails,
            'item_details' => $itemDetails,
            'custumer_details' => $custumerDetails,
        ];

        $snapToken = Snap::getSnapToken($params);

        Payment::create([
            'order_id' => $order->id,
            'amount' => $total,
            'status' => 'pending',
            'snap_token' => $snapToken,
        ]);

        DB::commit();
        session()->forget('cart');
        return redirect()->route('checkout.payment', $order->id)->with('snap_token', $snapToken);
    } catch (\Exception $e){
        DB::rollBack();
        return back()->with('error', ' Terjadi Kesalahan: ' . $e->getMessage());
    }
    }

    public function payment($orderId){
        $order = Order::with(['items.product', 'payment'])->findOrFail($orderId);

        if ($order->user_id !== (int) Auth::id()) {
            abort(403);
        }

        $snapToken = $order->payment->snap_token;
        $clientKey = config('midtrans.client_key');

        return view('checkout.payment', compact('order', 'snapToken', 'clientKey'));
    }

    public function success(Request $request){
        return view('checkout.success');
    }    
}
