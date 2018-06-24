@extends('layouts.frontLayout.front_design')
@section('content')
<div class="container text-center">
        <div class="content-404">
            <img src="images/frontend_images/404/404.png" class="img-responsive" alt="">
            <h1><b>Opps!!</b> We could not find this page</h1>
            <p>The page you are lokking for has up and vanished</p>
            <h2><a href="{{asset('./')}}">Bring me back Home</a></h2>
        </div>
</div>
@endsection