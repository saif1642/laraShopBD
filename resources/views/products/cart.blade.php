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
                            <a href=""><img style="width:100px" src="{{ asset('images/backend_images/products/medium/'.$cart->image) }}" alt=""></a>
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
                                <a class="cart_quantity_up" href="{{url('/cart/update-quantity/'.$cart->id.'/1')}}"> + </a>
                                <input class="cart_quantity_input" type="text" name="quantity" value="{{$cart->quantity}}" autocomplete="off" size="2">
                                @if($cart->quantity>0)
                                <a class="cart_quantity_down" href="{{url('/cart/update-quantity/'.$cart->id.'/-1')}}"> - </a>
                                @endif
                            </div>
                        </td>
                        <td class="cart_total">
                            <p class="cart_total_price">${{$cart->price*$cart->quantity}}</p>
                        </td>
                        <td class="cart_delete">
                            <a class="cart_quantity_delete" href="{{ url('/cart/delete-product/'.$cart->id) }}"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section> <!--/#cart_items-->

<section id="do_action">
    <div class="container">
        <div class="heading">
            <h3>What would you like to do next?</h3>
            <p>Choose if you have a Coupon code you want to use.</p>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="chose_area">
                    <ul class="user_option">
                        <li>
                            <form action="{{url('/cart/apply-coupon')}}" method="POST">
                                {{ csrf_field() }}
                                <label>Use Coupon Code</label>
                                <input type="text" name="coupon_code" class="form-control">
                                <input type="submit" class="btn btn-default update" value="Apply Coupon" class="form-control">
                            </form>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="total_area">
                    <ul>
                        @if(!empty(Session::get('CouponAmount')))
                            <li>Sub Total <span>BDT <?php echo $total_amount; ?></span></li>
                            <li>Coupon Discount <span>BDT <?php echo Session::get('CouponAmount'); ?></span></li>
                            <li>Grand Total <span>BDT <?php echo $total_amount - Session::get('CouponAmount'); ?></span></li>
                        @else
                            <li>Grand Total <span>BDT <?php echo $total_amount; ?></span></li>
                        @endif

                    </ul>
                        <a class="btn btn-default update" href="">Update</a>
                        <a class="btn btn-default check_out" href="">Check Out</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection