@extends('layouts.frontLayout.front_design')

@section('content')

    <section id="form" style="margin-top: 0px;"><!--form-->
        <div class="container">
            <div class="row">
                @if(Session::has('flash_message_error'))
                    <div class="alert alert-error alert-block">
                        <button type="button" class="close" data-dismiss="alert">x</button>
                        <strong>{!! session('flash_message_error') !!}</strong>
                    </div>
                @endif
                <div class="col-sm-4 col-sm-offset-1">
                    <div class="login-form"><!--login form-->
                        <h2>Update PAssword</h2>
                        <form action="{{url('/account/update-user-pwd')}}" id="passwordForm" name="passwordForm" method="post">
                            @csrf
                            <input type="password" name="current_pwd" id="current_pwd" placeholder="Current Password">
                            <span id="chkPwd"></span>

                            <input type="password" name="new_pwd" id="new_pwd" placeholder="New Password">

                            <input type="password" name="confirm_pwd" id="confirm_pwd" placeholder="Confirm Password">

                            <button type="submit" class="btn-default btn">Update Password</button>
                        </form>
                    </div><!--/login form-->
                </div>
                <div class="col-sm-1">
                    <h2 class="or">OR</h2>
                </div>
                <div class="col-sm-4">
                    <div class="signup-form"><!--sign up form-->
                        <h2>Update Account</h2>
                        <form action="{{url('/account')}}" id="accountForm" name="accountForm" method="post">
                            @csrf
                            <input type="text" name="name" id="name" placeholder="Name"  value="{{$userDetails->name}}"/>

                            <input type="text" name="address" id="address" placeholder="Address " value="{{$userDetails->address}}"/>

                            <input type="text" name="city" id="city" placeholder="City" value="{{$userDetails->city}}"/>

                            <input type="text" name="state" id="state" placeholder="State" value="{{$userDetails->state}}"/>

                            <select name="country" id="country">
                                <option value="">Select Country</option>
                                @foreach($countries as $country)
                                    <option value="{{$country->country_name}}" @if($country->country_name == $userDetails->country) selected @endif>{{$country->country_name}}</option>
                                    @endforeach
                            </select>

                            <input style="margin-top: 10px;" type="text" name="pincode" id="pincode" placeholder="Pin Code" value="{{$userDetails->pincode}}"/>

                            <input type="text" name="mobile" id="mobile" placeholder="Mobile" value="{{$userDetails->mobile}}"/>

                            <button type="submit" class="btn btn-default">Update</button>

                        </form>
                    </div><!--/sign up form-->
                </div>
            </div>
        </div>
    </section><!--/form-->

@endsection