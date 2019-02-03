@extends('layouts.frontLayout.front_design')
@section('content')

    @if(Session::has('flash_message_error'))
        <div class="alert alert-error alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong class="text-danger">{!! session('flash_message_error') !!}</strong>
        </div>
    @endif
    @if(Session::has('flash_message_success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{!! session('flash_message_success') !!}</strong>
        </div>
    @endif
    <section id="form" style="margin-top:20px;"><!--form-->
        <div class="container">

                <div class="row">
                    <div class="col-sm-4 col-sm-offset-1">
                        <div class="login-form"><!--login form-->
                            <h2>Billing Address</h2>
                            <div class="form-group">
                                <input type="text" placeholder="Billing Name" class="form-control" name="billing_name" id="billing_name" value="{{$userDetails->name}}" />
                            </div>

                            <div class="form-group">
                                <input type="text" placeholder="Billing Address" class="form-control" name="billing_address" id="billing_address" value="{{$userDetails->address}}" />
                            </div>

                            <div class="form-group">
                                <input type="text" placeholder="Billing City" class="form-control" name="billing_city" id="billing_city" value="{{$userDetails->city}}" />
                            </div>
                            <div class="form-group">
                                <input type="text" placeholder="Billing State" class="form-control" name="billing_state" id="billing_state" value="{{$userDetails->state}}" />
                            </div>
                            <div class="form-group">
                                <input type="text" placeholder="Billing Country" class="form-control" name="billing_country" id="billing_country" value="{{$userDetails->country}}" />
                            </div>
                            <div class="form-group">
                                <input type="text" placeholder="Billing Pincode" class="form-control" name="billing_pincode" id="billing_pincode" value="{{$userDetails->pincode}}"/>
                            </div>
                            <div class="form-group">
                                <input type="text" placeholder="Billing Mobile" class="form-control" name="billing_mobile" id="billing_mobile" value="{{$userDetails->mobile}}"/>
                            </div>




                        </div><!--/login form-->
                    </div>
                    <div class="col-sm-1">
                        <h2 class="or"></h2>
                    </div>
                    <div class="col-sm-4">
                        <div class="signup-form"><!--sign up form-->
                            <h2>Shipping Address</h2>
                            <div class="form-group">
                                <input type="text" placeholder="Shipping Name" id="shipping_name" name="shipping_name" class="form-control" value="{{$shippingDetails->name}}"/>
                            </div>

                            <div class="form-group">
                                <input type="text" placeholder="Shipping Address" id="shipping_address" name="shipping_address" value="{{$shippingDetails->address}}" class="form-control" />
                            </div>

                            <div class="form-group">
                                <input type="text" placeholder="Shipping City" id="shipping_city" name="shipping_city" value="{{$shippingDetails->city}}" class="form-control" />
                            </div>
                            <div class="form-group">
                                <input type="text" placeholder="Shipping State" id="shipping_state" name="shipping_state" value="{{$shippingDetails->state}}" class="form-control" />
                            </div>
                            <div class="form-group">
                                <input type="text" placeholder="Shipping Country" id="shipping_country" name="shipping_country" value="{{$shippingDetails->country}}"class="form-control" />
                            </div>
                            <div class="form-group">
                                <input type="text" placeholder="Shipping Pincode" id="shipping_pincode" name="shipping_pincode" value="{{$shippingDetails->pincode}}" class="form-control" />
                            </div>
                            <div class="form-group">
                                <input type="text" placeholder="Shipping Mobile" id="shipping_mobile" name="shipping_mobile" value="{{$shippingDetails->mobile}}" class="form-control" />
                            </div>

                        </div><!--/sign up form-->
                    </div>
                </div>
        </div>
    </section><!--/form-->

    <section id="cart_items">
        <div class="container">








            <div class="review-payment">
                <h2>Review & Payment</h2>
            </div>

            <div class="table-responsive cart_info">
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
                    <?php $total_amount = 0 ; ?>
                    @foreach($userCart as $cart)
                    <tr>
                        <td class="cart_product">
                            <a href=""><img src="{{asset('images/backend_images/products/small/'.$cart->image)}}" alt="" width="100px;"></a>
                        </td>
                        <td class="cart_description">
                            <h4><a href="">{{$cart->product_name}}</a></h4>
                            <p>Web ID: {{$cart->product_code}}</p>
                        </td>
                        <td class="cart_price">
                            <p>Rs. {{$cart->price}}</p>
                        </td>
                        <td class="cart_quantity">
                            <div class="cart_quantity_button">
                                <input class="cart_quantity_input" type="text" name="quantity" value="{{$cart->quantity}}" autocomplete="off" size="2">
                            </div>
                        </td>
                        <td class="cart_total">
                            <p class="cart_total_price">Rs. {{$cart->price * $cart->quantity}}</p>
                        </td>

                    </tr>

                        <?php $total_amount = $total_amount + ($cart->price * $cart->quantity); ?>
@endforeach

                    <tr>
                        <td colspan="4">&nbsp;</td>
                        <td colspan="2">
                            <table class="table table-condensed total-result">
                                <tr>
                                    <td>Cart Sub Total</td>
                                    <td>Rs. {{$total_amount}}</td>
                                </tr>

                                <tr class="shipping-cost">
                                    <td>Shipping Cost</td>
                                    <td>Free</td>
                                </tr>

                                <tr class="shipping-cost">
                                    <td>Discount Amount</td>
                                    @if(!empty(Session::get('CouponAmount')))
                                        <td><?php echo Session::get('CouponAmount'); ?></td>
                                        @else
                                        <td>0</td>
                                        @endif
                                </tr>

                                <tr>
                                    <td>Total</td>
                                    <td><span>Rs. <?php echo $grand_total = $total_amount - Session::get('CouponAmount'); ?></span></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <form action="{{url('/place-order')}}" name="paymentForm" id="paymentForm" method="post">
                @csrf
                <input type="hidden" name="grand_total" value="{{$grand_total}}">
            <div class="payment-options">
					<span>
						<label> Select Payment Method</label>
					</span>
                <span>
						<label><input type="radio" name="payment_method" id="COD" value="COD"> Cash on Delivery</label>
					</span>
                <span>
						<label><input type="radio" name="payment_method" id="paypal" value="Paypal"> Paypal</label>
					</span>
                <span style="float: right;">
                    <button type="submit" class="btn btn-primary" onclick="return selectPaymentMethod();">Place Order</button>
                </span>
            </div>
            </form>

        </div>
    </section> <!--/#cart_items-->

@endsection