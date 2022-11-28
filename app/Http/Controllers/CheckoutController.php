<?php

namespace App\Http\Controllers;

use App\Mail\CustomerInvoice;
use App\Models\Billing;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Inventory;
use App\Models\OrderProduct;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    function getCity(Request $request){
        $str = '<option value="">Select a City</option>';
        $cities = City::where('country_id', $request->country_id)->get();

        foreach($cities as $city){
            $str .= '<option value="'.$city->id.'">'.$city->name.'</option>';
        }
        echo $str;
    }

    function order_store(Request $request){
        if($request->payment_method == 1){

            $order_id = Order::insertGetId([
                'customer_id'=>Auth::guard('customerlogin')->id(),
                'sub_total'=> $request->sub_total,
                'discount'=> $request->discount_final,
                'delivery'=> $request->delivery,
                'total'=> $request->sub_total - $request->discount_final + ($request->delivery),
                'created_at'=> Carbon::now(),
            ]);

            Billing::insert([
                'order_id'=>$order_id,
                'customer_id'=>Auth::guard('customerlogin')->id(),
                'name'=>$request->name,
                'email'=>$request->email,
                'phone'=>$request->phone,
                'city_id'=>$request->city,
                'country_id'=>$request->country,
                'address'=>$request->address,
                'company'=>$request->company,
                'notes'=>$request->notes,
                'created_at'=> Carbon::now(),
            ]);

            $carts = Cart::where('customer_id', Auth::guard('customerlogin')->id())->get();
            foreach($carts as $cart){
                OrderProduct::insert([
                    'order_id'=>$order_id,
                    'customer_id'=>Auth::guard('customerlogin')->id(),
                    'product_id'=>$cart->product_id,
                    'color_id'=>$cart->color_id,
                    'size_id'=>$cart->size_id,
                    'price'=>$cart->rel_to_product->after_discount,
                    'quantity'=>$cart->quantity,
                    'created_at'=> Carbon::now(),
                ]);

                Inventory::where('product_id', $cart->product_id)->where('color_id', $cart->color_id)->where('size_id', $cart->size_id)->decrement('quantity', $cart->quantity);
                // Cart::find($cart->id)->delete();
            }

            $grand_total = $request->sub_total - $request->discount_final + ($request->delivery);
            Mail::to($request->email)->send(new CustomerInvoice($order_id));

            $url = "https://bulksmsbd.net/api/smsapi";
            $api_key = "THYPyGqnKBkmM1eq9nwS";
            $senderid = "8809601004414";
            $number = $request->phone;
            $message = "Your Order has been successfully placed! Your order id:$order_id, and Amount is:$grand_total";

            $data = [
                "api_key" => $api_key,
                "senderid" => $senderid,
                "number" => $number,
                "message" => $message
            ];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch);
            curl_close($ch);
            return redirect()->route('order.success')->with('ordersuccess', 'Your Order has been successfully placed!');
        }

        else if($request->payment_method == 2){
            $data = $request->all();
            return redirect()->route('pay')->with('data', $data);
        }

        else {
            $data = $request->all();
            return view('stripe', [
                'data'=>$data,
            ]);
        }
    }


    function order_success(){
        if(session('ordersuccess')){
            return view('frontend.ordersuccess');
        }
        else{
            abort(404);
        }
    }

}
