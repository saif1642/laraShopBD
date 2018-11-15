<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Session; 
class UsersController extends Controller
{
    public function userLoginRegister(){
        return view('users.login_register');
    }
    public function login(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            //dd($data);
            if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']])){
                Session::put('frontSession',$data['email']);
                return redirect('/cart');
             }else{
                return redirect()->back()->with('flash_message_error','Invalid Username and Password');
             }
        }
    }
    public function register(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            //dd($data);
            $userCount = User::where('email',$data['email'])->count();
            if($userCount > 0){
                return redirect()->back()->with('flash_message_error','User already exists');
            }else{
                $user = new User;
                $user->name = $data['name'];
                $user->email = $data['email'];
                $user->password = bcrypt($data['password']);
                $user->save();
                if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']])){
                    Session::put('frontSession',$data['email']);
                   return redirect('/cart');
                }
            }
            
           
        }
    }
    public function checkEmail(Request $request){
        $data = $request->all();
        $userCount = User::where('email',$data['email'])->count();
        if($userCount > 0){
             echo "false";
        }else{
            echo "true";
        }

    }
    public function logout(){
        
        Auth::logout();
        Session::forget('frontSession');
        return redirect('/');
    }
    public function account(){
        return view('users.account');
    }
}
