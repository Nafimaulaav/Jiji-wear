<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentApiController extends Controller
{
    public function notification(Request $request){
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');

        try{
            $notif = new \Midtrans\Notification();

            $transactionStatus = $notif->transaction_status;
            $fraudStatus = $notif->fraud_status;
            $orderId = $notif->order_id;

            $order = Order::where('order_number', $orderId)->first();

            if (!$order) {
                return response()->json(['message' => 'Order tidak ditemukan'], 404);
            }

            $payment = $order->payment;

            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'accept') {
                    $payment->update(['status' => 'success', 'payment_type' => $notif->payment_type, 'transaction_id' => $notif->transaction_id, 'midtrans_response' => $request->all()]);
                    $order->update(['status' => 'paid']);
                }
            } elseif ($transactionStatus == 'settlement') {
                $payment->update(['status' => 'success', 'payment_type' => $notif->payment_type, 'transaction_id' => $notif->transaction_id, 'midtrans_response' => $request->all()]);
                $order->update(['status' => 'paid']);
            } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])){
                $payment->update(['status' => 'failed', 'midtrans_response' => $request->all()]);
                $order->update(['status' => 'cancelled']);
            } elseif ($transactionStatus == 'pending') {
                $payment->update(['status' => 'pending', 'midtrans_response' => $request->all()]);
            }

            return response()->json(['message' => 'OK']);
        }catch (\Exception $e){
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
