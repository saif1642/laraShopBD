@extends('layouts.adminLayout.admin_design')
@section('content')
<div id="content">
<div id="content-header">
  <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a><a href="#" title="Go to Home" class="tip-bottom"> Products</a><a href="#" class="current">Edit Product</a> </div>
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
            <h5>Edit Products</h5>
          </div>
          <div class="widget-content nopadding">
            <form class="form-horizontal" method="post" enctype="multipart/form-data" action="{{url('/admin/edit-product/'.$product_details->id)}}" name="edit_product" id="edit_product" novalidate="novalidate">{{ csrf_field() }}
                <div class="control-group">
                    <label class="control-label">Product Category</label>
                    <div class="controls">
                        <select name="category_id" id="category_id" style="width:220px;">
                         <?php echo $categoryDropdownMenu; ?>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Product Name</label>
                    <div class="controls">
                        <input type="text" name="product_name" id="product_name" value="{{ $product_details->product_name }}"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Product Code</label>
                    <div class="controls">
                        <input type="text" name="product_code" id="product_code" value="{{ $product_details->product_code }}"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Product Color</label>
                    <div class="controls">
                        <input type="text" name="product_color" id="product_color" value="{{ $product_details->product_color }}"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Product Description</label>
                    <div class="controls">
                        <textarea name="description" id="description" cols="10" rows="5">{{ $product_details->description }}</textarea>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Material & Care</label>
                    <div class="controls">
                        <textarea name="care" id="care" cols="10" rows="5">{{ $product_details->care }}</textarea>
                    </div>
                </div>
                <div class="control-group">
                        <label class="control-label">Price</label>
                        <div class="controls">
                            <input type="text" name="price" id="price" value="{{ $product_details->price }}"/>
                        </div>
                </div>
                <input type="hidden" name="current_image" value="{{ $product_details->image }}">
                <div class="control-group">
                        <label class="control-label">Image {{ $product_details->image }}</label>
                        <div class="controls">
                            <input type="file" name="image" id="image" />
                            <img style="width:40px;" src="{{asset('/images/backend_images/products/small/'.$product_details->image)}}" alt="product image"> | 
                            <a href="{{ url('/admin/delete-product-image/'.$product_details->id) }}">Delete</a>
                        </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Enable</label>
                    <div class="controls">
                        <input type="checkbox" name="status" id="status" @if($product_details->status==1) checked @endif value="1"/>
                    </div>
                </div>
                <div class="form-actions">
                   <input type="submit" value="Edit Product" class="btn btn-success">
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
