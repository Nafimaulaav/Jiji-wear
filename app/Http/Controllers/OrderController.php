<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(){
        $orders = Order::with(['items.product', 'payment'])->where('user_id', Auth::id())->latest()->paginate(10);
        return view('order.index', compact('orders'));
    }

    public function show(Order $order) {
        if ($order->user_id !== Auth::id()){
            abort(403);
        }

        $order->load(['items.product', 'payment']);
        return view('order.show', compact('order'));
    }

}
