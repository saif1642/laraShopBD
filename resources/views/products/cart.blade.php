@extends('layouts.frontLayout.front_design')

@section('content')
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
              <li><a href="#">Home</a></li>
              <li class="active">Shopping Cart</li>
            </ol>
        </div>
        <div class="table-responsive cart_info">
            @if(Session::has('flash_message_error'))     
            <div class="alert alert-error alert-block">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>{!! Session('flash_message_error') !!}</strong>
            </div>
            @elseif(Session::has('flash_message_success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">x</button>
                    <strong>{!! Session('flash_message_success') !!}</strong>
                </div>
            @endif 
            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu">
                        <td class="image">Item</td>
                        <td class="description"></td>
                        <td class="price">Price</td>
                        <td class="quantity">Quantity</td>
                        <td class="total">Total</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($userCart as $cart)
                    <tr>
                        <td class="cart_product">
                            <a href=""><img src="images/cart/one.png" alt=""></a>
                        </td>
                        <td class="cart_description">
                            <h4><a href="">{{$cart->product_name}}</a></h4>
                            <p>Product ID: {{$cart->product_code}}</p>
                        </td>
                        <td class="cart_price">
                            <p>${{$cart->price}}</p>
                        </td>
                        <td class="cart_quantity">
                            <div class="cart_quantity_button">
                                <a class="cart_quantity_up" href=""> + </a>
                                <input class="cart_quantity_input" type="text" name="quantity" value="{{$cart->quantity}}" autocomplete="off" size="2">
                                <a class="cart_quantity_down" href=""> - </a>
                            </div>
                        </td>
                        <td class="cart_total">
                            <p class="cart_total_price">${{$cart->price*$cart->quantity}}</p>
                        </td>
                        <td class="cart_delete">
                            <a class="cart_quantity_delete" href=""><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section> <!--/#cart_items-->
@endsection