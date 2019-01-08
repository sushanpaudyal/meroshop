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
                                    <a href="{{asset('images/backend_images/products/large/'.$productDetails->image)}}">
                                <img style="width: 100%;" class="mainImage" src="{{asset('images/backend_images/products/medium/'.$productDetails->image)}}" alt="" />
                                    </a>
                                </div>
                                {{--<h3>ZOOM</h3>--}}
                            </div>
                            <div id="similar-product" class="carousel slide" data-ride="carousel">

                                <!-- Wrapper for slides -->
                                <div class="carousel-inner">
                                    <div class="item active thumbnails">
                                        @foreach($productAltImages as $altImage)
                                            <a href="{{asset('images/backend_images/products/large/'.$altImage->image)}}">
                                       <img class="changeImage" src="{{asset('images/backend_images/products/small/'.$altImage->image)}}" alt="" style="width:80px;">
                                            </a>
                                            @endforeach
                                    </div>



                                </div>


                            </div>

                        </div>
                        <div class="col-sm-7">
                            <div class="product-information"><!--/product-information-->
                                <img src="images/product-details/new.jpg" class="newarrival" alt="" />
                                <h2>{{$productDetails->product_name}}</h2>
                                <p>Code: {{$productDetails->product_code}}</p>
                                <p>
                                    <select name="size" style="width: 150px;" id="selSize">
                                        <option value="">Select Size</option>
                                        @foreach($productDetails->attributes as $sizes)
                                            <option value="{{$productDetails->id}}-{{$sizes->size}}">{{$sizes->size}}</option>
                                            @endforeach
                                    </select>
                                </p>
                                <span>
									<span id="getPrice">NPR {{$productDetails->price}}</span>
									<label>Quantity:</label>
									<input type="text" value="1" />
                                    @if($total_stock > 0)
									<button type="button" class="btn btn-fefault cart cartButton" id="cartButton">
										<i class="fa fa-shopping-cart"></i>
										Add to cart
									</button>
                                    @endif
								</span>
                                <p><b>Availability:</b> <span id="availability" class="availability">@if($total_stock > 0) In Stock @else Out of Stock @endif</span></p>
                                <p><b>Condition:</b> New</p>
                                <a href=""><img src="images/product-details/share.png" class="share img-responsive"  alt="" /></a>
                            </div><!--/product-information-->
                        </div>
                    </div><!--/product-details-->

                    <div class="category-tab shop-details-tab"><!--category-tab-->
                        <div class="col-sm-12">
                            <ul class="nav nav-tabs">
                                <li><a href="#description" data-toggle="tab">Description</a></li>
                                <li><a href="#care" data-toggle="tab">Material &amp; Care </a></li>
                                <li><a href="#delivery" data-toggle="tab">Delivery Options</a></li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane active in" id="description" >
                                <div class="col-sm-12">
                                    <p>
                                        {{$productDetails->description}}
                                    </p>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="care" >
                                <div class="col-sm-12">
                                    <p>
                                        {{$productDetails->care}}
                                    </p>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="delivery" >
                                <div class="col-sm-12">
                                    <p>100% More Original Products <br>
                                    Cash on Delivery</p>
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
                                <div <?php if($count == 1){ ?> class="item active" <?php } else { ?> class="item" <?php } ?>>
                                    @foreach($chunk as $item)
                                    <div class="col-sm-4">
                                        <div class="product-image-wrapper">
                                            <div class="single-products">
                                                <div class="productinfo text-center">
                                                    <img src="{{asset('images/backend_images/products/small/'.$item->image)}}" alt="" />
                                                    <h2>Rs. {{$item->price}}</h2>
                                                    <p>{{$item->product_name}}</p>
                                                    <a href="{{route('product', $item->id)}}">
                                                    <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                   @endforeach
                                </div>
                                    <?php $count++ ?>
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
