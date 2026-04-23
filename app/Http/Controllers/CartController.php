<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(){
        $cart = session()->get('cart', []);
        $total = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));
        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request,Product $product){
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'size' => 'required|string',
            'color' => 'required|string',
        ]);

        $cart = session()->get('cart', []);
        $cartKey = $product->id . '_' . $request->size . '_' . $request->color;

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $request->quantity;
        } else {
            $cart[$cartKey] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $request->image_url,
                'size' => $request->size,
                'color' => $request->color,
                'quantity' => $request->quantity,
            ];
        }
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request, $key){
        $cart = session()->get('cart', []);
        if(isset($cart[$key])){
            if ($request->quantity < 1){
                unset($cart[$key]);
            } else {
                $cart[$key]['quantity'] = $request->quantity;
            }
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Keranjang berhasil diperbarui!');
    }

    public function remove($key){
        $cart = session()-> get('cart', []);
        unset($cart[$key]);
        session()->put('cart',$cart);
        return redirect()->back()->with('success', 'Produk dihapus dari keranjang!');
    }

    public function clear(){
        session()->forget('cart');
        return redirect()->back()->with('success', 'Keranjang dikosongkan!');
    }
}
