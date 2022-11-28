<?php

namespace App\Http\Controllers;

use App\Models\CustomerEmailVerify;
use App\Models\CustomerLogin;
use App\Models\CustomerPasswordReset;
use App\Models\OrderProduct;
use App\Notifications\CustomerPassResetNotification;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    function invoicedownlaod($order_id){
        $pdf = Pdf::loadView('invoice.customerinvoice', [
            'order_id'=>$order_id
        ]);
        return $pdf->stream('invoice.pdf');
    }

    function review(Request $request){
        OrderProduct::where('customer_id', Auth::guard('customerlogin')->id())->where('product_id', $request->product_id)->update([
            'review'=>$request->review,
            'star'=>$request->star,
        ]);
        return back();
    }

    function password_reset_request_form(){
        return view('frontend.pass_reset_req_form');
    }
    function password_reset_request_send(Request $request){
      $customer = CustomerLogin::where('email', $request->email)->firstOrFail();
      CustomerPasswordReset::where('customer_id', $customer->id)->delete();

      $pass_reset = CustomerPasswordReset::create([
        'customer_id'=>$customer->id,
        'reset_token'=>uniqid(),
        'created_at'=>Carbon::now(),
      ]);

      Notification::send($customer , new CustomerPassResetNotification($pass_reset));
      return back()->with('reset', 'we have sent you a password reset link, please check your email');
    }

    function password_reset_form($reset_token){
        return view('passreset.pass_reset_form', [
            'data'=>$reset_token,
        ]);
    }

    function pass_reset_update(Request $request){
        $customer_token = CustomerPasswordReset::where('reset_token', $request->reset_token)->firstOrFail();
        $customer = CustomerLogin::findOrFail($customer_token->customer_id);

        $customer->update([
            'password'=>Hash::make($request->password),
        ]);

        $customer_token->delete();
        return redirect('/customer/register/')->with('reset', 'Password Reset Success');
    }

    function email_veify($verify_token){
        $token = CustomerEmailVerify::where('verify_token', $verify_token)->firstOrFail();
        $customer = CustomerLogin::findOrFail($token->customer_id);

        $customer->update([
            'email_verified_at'=>Carbon::now(),
        ]);
        $token->delete();

        return redirect('/customer/register/')->with('verify', 'email verified success!');
    }
}
