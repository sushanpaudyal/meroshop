<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Auth;

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
        return redirect('/');
    }

}
