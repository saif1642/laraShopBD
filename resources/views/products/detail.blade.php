@extends('layouts.frontLayout.front_design')

@section('content')
<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                @include('layouts.frontLayout.front_sidebar')
            </div>
            
            <div class="col-sm-9 padding-right">
                <div class="product-details"><!--product-details-->
                    <div class="col-sm-5">
                        <div class="view-product">
                            <div class="easyzoom easyzoom--overlay easyzoom--with-thumbnails">
                                <a href="{{ asset('images/backend_images/products/large/'.$productDetail->image) }}" data-standard="{{asset('/images/backend_images/products/small/'.$productDetail->image)}}">
                                    <img style="width: 300px;" class="mainImage" src="{{ asset('images/backend_images/products/medium/'.$productDetail->image) }}" alt="" />
                                </a>
                            </div>
                        </div>
                        <div id="similar-product" class="carousel slide" data-ride="carousel">  
                              <!-- Wrapper for slides -->
                                <div class="carousel-inner">
                                    <div class="item active thumbnails">
                                      @foreach($productImages as $image)
                                        <a href="{{asset('/images/backend_images/products/large/'.$image->image)}}" data-standard="{{asset('/images/backend_images/products/small/'.$image->image)}}">
                                            <img class="changeImage" style="width:80px;cursor:pointer;"  src="{{asset('/images/backend_images/products/small/'.$image->image)}}" alt="product image">
                                        </a>
                                      @endforeach
                                    </div>                          
                                </div>

                              <!-- Controls -->
                              <a class="left item-control" href="#similar-product" data-slide="prev">
                                <i class="fa fa-angle-left"></i>
                              </a>
                              <a class="right item-control" href="#similar-product" data-slide="next">
                                <i class="fa fa-angle-right"></i>
                              </a>
                        </div>

                    </div>
                    <div class="col-sm-7">
                        <div class="product-information"><!--/product-information-->
                            <img src="images/product-details/new.jpg" class="newarrival" alt="" />
                            <h2>{{ $productDetail->product_name }}</h2>
                            <p>Web ID: {{ $productDetail->product_code }}</p>
                            <p>
                                <select id="selSize" name="size" style="width:150px">
                                    <option value="">Select</option>
                                    @foreach($productDetail->attributes as $attribute)
                                       <option value="{{ $productDetail->id}}-{{$attribute->size}}">{{$attribute->size}}</option>
                                    @endforeach
                                </select>
                            </p>
                            <img src="images/product-details/rating.png" alt="" />
                            <span>
                                <span id="getPrice">US ${{ $productDetail->price }}</span>
                                <label>Quantity:</label>
                                <input type="text" value="3" />
                                <button type="button" class="btn btn-fefault cart">
                                    <i class="fa fa-shopping-cart"></i>
                                    Add to cart
                                </button>
                            </span>
                            <p><b>Availability:</b> In Stock</p>
                            <p><b>Condition:</b> New</p>
                            <p><b>Brand:</b> E-SHOPPER</p>
                            <a href=""><img src="images/product-details/share.png" class="share img-responsive"  alt="" /></a>
                        </div><!--/product-information-->
                    </div>
                </div><!--/product-details-->
                
                <div class="category-tab shop-details-tab"><!--category-tab-->
                    <div class="col-sm-12">
                        <ul class="nav nav-tabs">
                            <li><a href="#description" data-toggle="tab">Description</a></li>
                            <li><a href="#care" data-toggle="tab">Material & Care</a></li>
                            <li><a href="#delivery" data-toggle="tab">Delivery Options</a></li>
                            
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade" id="description" >
                            <div class="col-sm-12">
                                <p>
                                    {{ $productDetail->description }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="tab-pane fade" id="care" >
                            <div class="col-sm-12">
                                <p>
                                    {{ $productDetail->care }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="tab-pane fade" id="delivery" >
                            <div class="col-sm-12">
                                <p>
                                    100% original products<br>
                                    Cash On Delivery
                                </p>
                            </div>
                        </div>
                        

                        
                    </div>
                </div><!--/category-tab-->
                
                <div class="recommended_items"><!--recommended_items-->
                    <h2 class="title text-center">recommended items</h2>
                    
                    <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <?php $count = 1; ?>
                            @foreach($relatedProducts->chunk(3) as $chunk)	
                                <div <?php if($count==1){ ?> class="item active" <?php }else{ ?>class="item" <?php } ?>>
                                    @foreach($chunk as $item)
                                        <div class="col-sm-4">
                                            <div class="product-image-wrapper">
                                                <div class="single-products">
                                                    <div class="productinfo text-center">
                                                        <img style="width:200px;" src="{{ asset('images/backend_images/products/large/'.$item->image) }}" alt="" />
                                                        <h2>${{$item->price}}</h2>
                                                        <p>{{$item->product_name}}</p>
                                                        <a href="{{ url('product/'.$item->id )}}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                       
                                    @endforeach
                                </div>
                            <?php $count++;?>
                            @endforeach
                        </div>
                         <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
                            <i class="fa fa-angle-left"></i>
                          </a>
                          <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
                            <i class="fa fa-angle-right"></i>
                          </a>			
                    </div>
                </div><!--/recommended_items-->
                
            </div>
        </div>
    </div>
</section>
@endsection