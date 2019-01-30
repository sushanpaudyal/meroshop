@extends('layouts.frontLayout.front_design')
@section('content')

    <section id="form" style="margin-top:20px;"><!--form-->
        <div class="container">
            <form action="#">
            <div class="row">
                <div class="col-sm-4 col-sm-offset-1">
                    <div class="login-form"><!--login form-->
                        <h2>Bill To</h2>
                        <div class="form-group">
                            <input type="text" placeholder="Billing Name" class="form-control" />
                        </div>

                        <div class="form-group">
                            <input type="text" placeholder="Billing Address" class="form-control" />
                        </div>

                        <div class="form-group">
                            <input type="text" placeholder="Billing City" class="form-control" />
                        </div>
                        <div class="form-group">
                            <input type="text" placeholder="Billing State" class="form-control" />
                        </div>
                        <div class="form-group">
                            <input type="text" placeholder="Billing Country" class="form-control" />
                        </div>
                        <div class="form-group">
                            <input type="text" placeholder="Billing Pincode" class="form-control" />
                        </div>
                        <div class="form-group">
                            <input type="text" placeholder="Billing Mobile" class="form-control" />
                        </div>


                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="billtoship">
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
                        <form action="#">
                            <div class="form-group">
                                <input type="text" placeholder="Shipping Name" class="form-control" />
                            </div>

                            <div class="form-group">
                                <input type="text" placeholder="Shipping Address" class="form-control" />
                            </div>

                            <div class="form-group">
                                <input type="text" placeholder="Shipping City" class="form-control" />
                            </div>
                            <div class="form-group">
                                <input type="text" placeholder="Shipping State" class="form-control" />
                            </div>
                            <div class="form-group">
                                <input type="text" placeholder="Shipping Country" class="form-control" />
                            </div>
                            <div class="form-group">
                                <input type="text" placeholder="Shipping Pincode" class="form-control" />
                            </div>
                            <div class="form-group">
                                <input type="text" placeholder="Shipping Mobile" class="form-control" />
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success">Checkout</button>
                            </div>
                        </form>
                    </div><!--/sign up form-->
                </div>
            </div>
            </form>
        </div>
    </section><!--/form-->

    @endsection