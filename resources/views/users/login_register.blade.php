@extends('layouts.frontLayout.front_design')

@section('content')
<section id="form"><!--form-->
    <div class="container">
            @if(Session::has('flash_message_error'))     
            <div class="alert alert-error alert-block" style="background-color:red;color:white">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>{!! Session('flash_message_error') !!}</strong>
            </div>
            @elseif(Session::has('flash_message_success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">x</button>
                    <strong>{!! Session('flash_message_success') !!}</strong>
                </div>
            @endif 
        <div class="row">
            <div class="col-sm-4 col-sm-offset-1">
                <div class="login-form"><!--login form-->
                    <h2>Login to your account</h2>
                    <form action="{{ url('/user-login') }}" method="POST" id="loginForm">
                        {{ csrf_field() }} -
                        <input type="email" name="email" placeholder="Email Address" />
                        <input type="password" name="password" placeholder="Password" />
                        <span style="padding-top:5px">
                            <input type="checkbox" class="checkbox"> 
                            Keep me signed in
                        </span>
                        <button type="submit" class="btn btn-default">Login</button>
                    </form>
                </div><!--/login form-->
            </div>
            <div class="col-sm-1">
                <h2 class="or">OR</h2>
            </div>
            <div class="col-sm-4">
                <div class="signup-form"><!--sign up form-->
                    <h2>New User Signup!</h2>
                    <form id="registerForm" name="registerForm" action="{{ url('/user-register') }}" method="POST">
                        {{ csrf_field() }} 
                        <input type="text" name="name" placeholder="Name"/>
                        <input type="email" name="email" placeholder="Email Address"/>
                        <input type="password" id="password" name="password" placeholder="Password"/>
                        <button type="submit" class="btn btn-default">Signup</button>
                    </form>
                </div><!--/sign up form-->
            </div>
        </div>
    </div>
</section><!--/form-->
@stop