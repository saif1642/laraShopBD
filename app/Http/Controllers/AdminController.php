<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Auth;
use App\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function login(Request $request){
        if($request->isMethod('post')){
            $data = $request->input();
            if(Auth::attempt(['email' => $data['email'],'password'=> $data['password'],'admin'=>'1'])){
                return redirect('/admin/dashboard');
            }else{
                return redirect('/admin')->with('flash_message_error','Invalid Username or Password');
            }
        }
        return view('admin.admin_login');
    }

    public function dashboard(){
        return view('admin.dashboard');
    }

    public function setting(){
        return view('admin.setting');
    }

    public function checkPassword(Request $request){
          $data = $request->all();
          $current_password = $data['current_pwd'];
          $check_password = User::where(['admin'=>'1'])->first();
          if(Hash::check($current_password,$check_password->password)){
              echo "True";die;
          }else{
              echo "false";die;
          }
    }

    public function logout(){
       Session::flush();
       return redirect('/admin')->with('flash_message_success','Successfully Logged Out');
    }
}
