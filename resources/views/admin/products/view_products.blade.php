@extends('layouts.adminLayout.admin_design')

@section('content')

<div id="content">
    <div id="content-header">
      <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a><a href="#" title="Go to Home" class="tip-bottom">Products</a> <a href="#" class="current">View Products</a> </div>
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
    <div class="container-fluid">
      <hr>
      <div class="row-fluid">
        <div class="span12">
          <div class="widget-box">
            <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
              <h5>Products table</h5>
            </div>
            <div class="widget-content nopadding">
              <table class="table table-bordered data-table">
                <thead>
                  <tr>
                    <th>Product ID</th>
                    <th>Category ID</th>
                    <th>Category Name</th>
                    <th>Product Name</th>
                    <th>Product Color</th>
                    <th>Product Code</th>
                    <th>Product Price</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                  <tr class="gradeX">
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->category_id }}</td>
                    <td>{{ $product->category }}</td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->product_color }}</td>
                    <td>{{ $product->product_code }}</td>
                    <td>${{ $product->price }}</td>
                    <td>
                      <img src="{{asset('/images/backend_images/products/small/'.$product->image)}}" alt="product image" width="60px" height="60px">
                    </td>
                    <td class="center"><a href="{{url('/admin/edit-product/'.$product->id)}}" class="btn btn-primary btn-mini">Edit</a> <a id="del_cat" href="{{url('/admin/delete-product/'.$product->id)}}" class="btn btn-danger btn-mini">Delete</a></td>
                  </tr>
                @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


@endsection