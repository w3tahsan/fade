<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    function orders(){
        $orders = Order::all();
        return view('admin.order.orders', [
            'orders'=>$orders,
        ]);
    }

    function order_status(Request $request){
        $after_explode = explode(',', $request->status);
        $order_id = $after_explode[0];
        $staus = $after_explode[1];

        Order::find($order_id)->update([
            'status'=>$staus,
        ]);

        return back();
    }
}
