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
            <form action="{{url('checkout')}}" method="post">
                @csrf
            <div class="row">
                <div class="col-sm-4 col-sm-offset-1">
                    <div class="login-form"><!--login form-->
                        <h2>Bill To</h2>
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


                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="copyAddress">
                            <label for="billtoship" class="form-check-label">Shipping Address Same as Billing</label>
                        </div>

                    </div><!--/login form-->
                </div>
                <div class="col-sm-1">
                    <h2 class="or"></h2>
                </div>
                <div class="col-sm-4">
                    <div class="signup-form"><!--sign up form-->
                        <h2>Ship To</h2>
                            <div class="form-group">
                                <input type="text" placeholder="Shipping Name" id="shipping_name" name="shipping_name" class="form-control" value="@if(empty($shippingDetails->name)) @else {{$shippingDetails->name}} @endif"/>
                            </div>

                            <div class="form-group">
                                <input type="text" placeholder="Shipping Address" id="shipping_address" name="shipping_address" value="@if(empty($shippingDetails->address)) @else {{$shippingDetails->address}} @endif" class="form-control" />
                            </div>

                            <div class="form-group">
                                <input type="text" placeholder="Shipping City" id="shipping_city" name="shipping_city" value="" class="form-control" />
                            </div>
                            <div class="form-group">
                                <input type="text" placeholder="Shipping State" id="shipping_state" name="shipping_state" value="" class="form-control" />
                            </div>
                            <div class="form-group">
                                <input type="text" placeholder="Shipping Country" id="shipping_country" name="shipping_country" value=""class="form-control" />
                            </div>
                            <div class="form-group">
                                <input type="text" placeholder="Shipping Pincode" id="shipping_pincode" name="shipping_pincode" value="" class="form-control" />
                            </div>
                            <div class="form-group">
                                <input type="text" placeholder="Shipping Mobile" id="shipping_mobile" name="shipping_mobile" value="" class="form-control" />
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success">Checkout</button>
                            </div>
                    </div><!--/sign up form-->
                </div>
            </div>
            </form>
        </div>
    </section><!--/form-->

    @endsection