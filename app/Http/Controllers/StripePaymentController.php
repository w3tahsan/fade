<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Stripe;
use App\Mail\CustomerInvoice;
use App\Models\Billing;
use App\Models\City;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Inventory;
use App\Models\OrderProduct;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {
        return view('stripe');
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create ([
                "amount" => $request->total_pay * 100,
                "currency" => "bdt",
                "source" => $request->stripeToken,
                "description" => "Test payment from itsolutionstuff.com."
        ]);

        $data = session('data');

        $order_id = Order::insertGetId([
            'customer_id'=>$data['customer_id'],
            'sub_total'=> $data['sub_total'],
            'discount'=> $data['discount_final'],
            'delivery'=> $data['delivery'],
            'total'=> $data['sub_total'] - $data['discount_final'] + ($data['delivery']),
            'created_at'=> Carbon::now(),
        ]);

        Billing::insert([
            'order_id'=>$order_id,
            'customer_id'=>$data['customer_id'],
            'name'=>$data['name'],
            'email'=>$data['email'],
            'phone'=>$data['phone'],
            'city_id'=>$data['city'],
            'country_id'=>$data['country'],
            'address'=>$data['address'],
            'company'=>$data['company'],
            'notes'=>$data['notes'],
            'created_at'=> Carbon::now(),
        ]);


        $carts = Cart::where('customer_id', $data['customer_id'])->get();
        foreach($carts as $cart){
            OrderProduct::insert([
                'order_id'=>$order_id,
                'customer_id'=>$data['customer_id'],
                'product_id'=>$cart->product_id,
                'color_id'=>$cart->color_id,
                'size_id'=>$cart->size_id,
                'price'=>$cart->rel_to_product->after_discount,
                'quantity'=>$cart->quantity,
                'created_at'=> Carbon::now(),
            ]);

            Inventory::where('product_id', $cart->product_id)->where('color_id', $cart->color_id)->where('size_id', $cart->size_id)->decrement('quantity', $cart->quantity);
            Cart::find($cart->id)->delete();
            }

            $grand_total = $data['sub_total'] - $data['discount_final'] + ($data['delivery']);
            Mail::to($data['email'])->send(new CustomerInvoice($order_id));

            $url = "https://bulksmsbd.net/api/smsapi";
            $api_key = "THYPyGqnKBkmM1eq9nwS";
            $senderid = "8809601004414";
            $number = $data['phone'];
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
}
