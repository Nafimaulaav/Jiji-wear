<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class OrderApiController extends Controller
{
    public function index(){
        $order = Order::with(['items.product', 'payment'])->where('user_id', Auth::id())->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $order,
        ]);
    }

    public function show(Order $order){

    if ($order->user_id !== Auth::id()){
        return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
    }

    return response()->json([
        'success' => true,
        'data' => $order->load(['items.product', 'payment']),
    ]);
    }
}
