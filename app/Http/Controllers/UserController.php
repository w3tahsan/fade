<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Image;

class UserController extends Controller
{
    function users(){
        $users = User::where('id', '!=', Auth::id())->get();
        $total_user = User::count();
        return view('admin.users.user_list', compact('users', 'total_user'));
    }

    function delete($user_id){
       User::find($user_id)->delete();
       return back()->with('delete', 'User Deleted Success!');
    }

    function profile(){
        return view('admin.users.profile');
    }

    function name_change(Request $request){
       User::find(Auth::id())->update([
            'name'=>$request->name,
       ]);
       return back()->with('success', 'Name Has been updated!');
    }

    function password_change(Request $request){
        $request->validate([
            'old_password'=> 'required',
            'password'=> ['required','confirmed', Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
            'password_confirmation'=> 'required',
        ],[
            'old_password.required'=>'Old Password de',
            'password.required'=>'Password de',
            'password_confirmation.required'=>'Abar Password de',
            'password.confirmed'=>'Password r Confirm Password Mile nai',
        ]);

        if(Hash::check($request->old_password, Auth::user()->password)){
            User::find(Auth::id())->update([
                'password'=>bcrypt($request->password),
            ]);

            return back()->with('pass_success', 'Password Has been updated!');
        }
        else{
            return back()->with('wrong', 'thik thak moto puran password de');
        }
    }


    function photo_change(Request $request){
        $profile_photo = $request->profile_photo;

        if(Auth::user()->profile_photo != null){
            $path = public_path('uploads/user/'.Auth::user()->profile_photo);
            unlink($path);

            $extension = $profile_photo->getClientOriginalExtension();
            $file_name = Auth::id().'.'.$extension;
            $img = Image::make($profile_photo)->save(public_path('uploads/user/'.$file_name));

            User::find(Auth::id())->update([
                'profile_photo'=>$file_name,
            ]);
            return back()->with('photo_success', 'Photo Has been updated!');
        }

        else{
            $extension = $profile_photo->getClientOriginalExtension();
            $file_name = Auth::id().'.'.$extension;
            $img = Image::make($profile_photo)->save(public_path('uploads/user/'.$file_name));

            User::find(Auth::id())->update([
                'profile_photo'=>$file_name,
            ]);
            return back()->with('photo_success', 'Photo Has been updated!');
        }
    }


}
