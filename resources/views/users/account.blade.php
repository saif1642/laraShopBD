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
                    <h2>Update to your account</h2>
                   
                </div><!--/login form-->
            </div>
            <div class="col-sm-1">
                <h2 class="or">OR</h2>
            </div>
            <div class="col-sm-4">
                <div class="signup-form"><!--sign up form-->
                    <h2>Update User Password</h2>
                 
                </div><!--/sign up form-->
            </div>
        </div>
    </div>
</section><!--/form-->
@stop