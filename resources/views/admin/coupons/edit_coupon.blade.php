@extends('layouts.adminLayout.admin_design')
@section('content')
<div id="content">
<div id="content-header">
  <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a><a href="#" title="Go to Home" class="tip-bottom"> Coupons</a><a href="#" class="current">Edit Coupon</a> </div>
  <h1>Coupons</h1>
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
</div>
<div class="container-fluid"><hr>
  <div class="row-fluid">
  </div>
  <div class="row-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>Edit Coupon</h5>
          </div>
          <div class="widget-content nopadding">
            <form class="form-horizontal" method="post" action="{{ url('/admin/edit-coupon',['id'=>$coupon->id]) }}" name="edit_coupon" id="edit_coupon">{{ csrf_field() }}
                <div class="control-group">
                    <label class="control-label">Coupon Code</label>
                    <div class="controls">
                        <input type="text" name="coupon_code" id="coupon_code" minlength="5" maxlength="15" required value="{{$coupon->coupon_code}}"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Amount</label>
                    <div class="controls">
                        <input type="number" name="amount" id="amount" required min="0" value="{{$coupon->amount}}"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Amount Type</label>
                        <div class="controls">
                            <select name="amount_type" id="amount_type" style="width:220px;">
                               <option  @if($coupon->amount_type == "percentage") selected @endif value="percentage">Percentage</option>
                               <option @if($coupon->amount_type == "fixed") selected @endif
                                value="fixed">Fixed</option>
                            </select>
                        </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Expiry Date</label>
                    <div class="controls">
                        <input type="text" name="expiry_date" id="expiry_date" required value="{{$coupon->expiry_date}}"/>
                    </div>
                </div>
               
                <div class="control-group">
                    <label class="control-label">Enable</label>
                    <div class="controls">
                        <input type="checkbox" name="status" id="status" @if($coupon->status==1) checked @endif/>
                    </div>
                </div>
                <div class="form-actions">
                   <input type="submit" value="Edit Coupon" class="btn btn-success">
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
@endsection
