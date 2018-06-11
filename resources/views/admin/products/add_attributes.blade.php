@extends('layouts.adminLayout.admin_design')
@section('content')
<div id="content">
<div id="content-header">
  <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a><a href="#" title="Go to Home" class="tip-bottom"> Products</a><a href="#" class="current">Add Attribute</a> </div>
  <h1>Products</h1>
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
            <h5>Add Attribute</h5>
          </div>
          <div class="widget-content nopadding">
            <form class="form-horizontal" method="post" enctype="multipart/form-data" action="{{ url('/admin/add-attributes/'.$product_details->id) }}" name="add_attributes" id="add_attributes" novalidate="novalidate">{{ csrf_field() }}
                <input type="hidden" name="product_id" value="{{ $product_details->id }}">
                <div class="control-group">
                    <label class="control-label">Product Name:</label>
                    <label class="control-label"><strong>{{ $product_details->product_name }}</strong></label>
                </div>
                <div class="control-group">
                    <label class="control-label">Product Code:</label>
                    <label class="control-label"><strong>{{ $product_details->product_code }}</strong></label>
                </div>
                <div class="control-group">
                    <label class="control-label">Product Color:</label>
                    <label class="control-label"><strong>{{ $product_details->product_color }}</strong></label>
                </div>
                <div class="control-group">
                    <label class="control-label"></label>
                    <div class="field_wrapper">
                        <div>
                            <input type="text" name="sku[]" id="sku" placeholder="SKU" style="width:120px;"/>
                            <input type="text" name="size[]" id="size" placeholder="Size" style="width:120px;"/>
                            <input type="text" name="price[]" id="price" placeholder="Price" style="width:120px;"/>
                            <input type="text" name="stock[]" id="stock" placeholder="Stock" style="width:120px;"/>
                            <a href="javascript:void(0);" class="add_button btn btn-primary" title="Add field">Add</a>
                        </div>
                    </div>
    
                </div>
                
                <div class="form-actions">
                   <input type="submit" value="Add Attributes" class="btn btn-success">
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
