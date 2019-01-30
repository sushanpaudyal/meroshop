<?php

namespace App\Http\Controllers;

use App\Country;
use App\User;
use Illuminate\Http\Request;
use Auth;
use Session;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{

    public function userLoginRegister(){
        return view ('users.login_register');
    }

    public function register(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            // check if user already exists;
            $usersCount = User::where('email', $data['email'])->count();
            if($usersCount > 0){
                return redirect()->back()->with('flash_message_error', 'Email Already Exits');
            } else {
                $user = new User;
                $user->name = $data['name'];
                $user->email = $data['email'];
                $user->password = bcrypt($data['password']);
                $user->admin = "0";
                $user->save();
                if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']])){
                    Session::put('frontSession', $data['email']);
                    return redirect('/cart');
                }
            }
        }
    }

    public function checkEmail(Request $request){
        $data = $request->all();
        $usersCount = User::where('email', $data['email'])->count();
        if($usersCount > 0){
            echo "false";
        } else {
            echo "Success"; die;
        }
    }

    public function logout(){
        Auth::logout();
        Session::forget('frontSession');
        return redirect('/');
    }


    public function login(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']])){
                Session::put('frontSession', $data['email']);
                return redirect('/cart');
            } else {
                return redirect()->back()->with('flash_message_error', 'Invalid Username or Password');
            }
        }
    }

    public function account(Request $request){
        $countries = Country::get();
        $user_id = Auth::user()->id;
        $userDetails = User::find($user_id);

        if($request->isMethod('post')){
            $data = $request->all();
            $user = User::find($user_id);

            if(empty($data['name'])){
                return redirect()->back()->with('flash_message_error', 'Name is Required');
            }

            if(empty($data['address'])){
                $data['address'] = "";
            }

            if(empty($data['city'])){
                $data['city'] = "";
            }

            if(empty($data['state'])){
                $data['state'] = "";
            }

            $user->name = $data['name'];
            $user->address = $data['address'];
            $user->city = $data['city'];
            $user->state = $data['state'];
            $user->country = $data['country'];
            $user->pincode = $data['pincode'];
            $user->mobile = $data['mobile'];
            $user->save();
            return redirect()->back()->with('flash_message_success', 'Account Updated Successfully');
        }

        return view ('users.account', compact('countries', 'userDetails'));
    }


    public function chkUserPassword(Request $request){
        $data = $request->all();
//        echo "<pre>"; print_r($data); die;
        $current_password = $data['current_pwd'];
        $user_id = Auth::user()->id;
        $check_password = User::where('id', $user_id)->first();
        if(Hash::check($current_password, $check_password->password)){
            echo "true"; die;
        } else {
            echo "False"; die;
        }
    }



    public function updatePassword(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
//            echo "<pre>"; print_r($data); die;
            $old_password = User::where('id', Auth::user()->id)->first();
            $current_pwd = $data['current_pwd'];
            if(Hash::check($current_pwd, $old_password->password)){
                $new_pwd = bcrypt($data['new_pwd']);
                User::where('id', Auth::user()->id)->update(['password' => $new_pwd]);
                return redirect()->back()->with('flash_message_success', 'Password Changed Successfully');
            } else {
                return redirect()->back()->with('flash_message_error', 'Old Password Doesnot Match');
            }

        }
    }

}
