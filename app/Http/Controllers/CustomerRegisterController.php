<?php

namespace App\Http\Controllers;

use App\Models\CustomerEmailVerify;
use App\Models\CustomerLogin;
use App\Notifications\CustomerEmailVerifyNotificaion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Illuminate\Support\Facades\Notification;

class CustomerRegisterController extends Controller
{
    function customer_register(){
        return view('frontend.customer_register');
    }

    function customer_register_store(Request $request){
        CustomerLogin::insert([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
            'created_at'=>Carbon::now(),
        ]);
        $customer = CustomerLogin::where('email', $request->email)->firstOrFail();
        CustomerEmailVerify::where('customer_id', $customer->id)->delete();

        $verify_email = CustomerEmailVerify::create([
            'customer_id'=>$customer->id,
            'verify_token'=>uniqid(),
            'created_at'=>Carbon::now(),
          ]);

        Notification::send($customer , new CustomerEmailVerifyNotificaion($verify_email));

        return back()->with('register', 'Customer Registered Success! We have sent you email verification link please verify before login');
    }
}
