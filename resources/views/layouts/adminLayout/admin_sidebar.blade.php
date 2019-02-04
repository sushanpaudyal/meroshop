<?php
   $url = url()->current(); ?>


<!--sidebar-menu-->
<div id="sidebar"><a href="#" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>
    <ul>
        <li
            <?php if(preg_match("/dashboard/i", $url)) { echo 'class="active"'; } ?>    >
            <a href="{{url('admin/dashboard')}}"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>

        <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Categories</span> </a>
            <ul <?php if(preg_match("/categor/i", $url)) { echo 'style="display:block;"';} ?>>
                <li <?php if(preg_match("/add-category/i", $url)) { echo 'class="active"';} ?>><a href="{{url('/admin/add-category')}}">Add Category</a></li>
                <li <?php if(preg_match("/view-categories/i", $url)) { echo 'class="active"';} ?>><a href="{{url('/admin/view-categories')}}">View Category</a></li>
            </ul>
        </li>

        <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Products</span> </a>
            <ul <?php if(preg_match("/product/i", $url)) { echo 'style="display:block;"';} ?>>
                <li <?php if(preg_match("/add-product/i", $url)) { echo 'class="active"';} ?>><a href="{{url('/admin/add-product')}}">Add Product</a></li>
                <li <?php if(preg_match("/view-products/i", $url)) { echo 'class="active"';} ?>><a href="{{url('/admin/view-products')}}">View Product</a></li>
            </ul>
        </li>


        <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Coupons</span> </a>
            <ul <?php if(preg_match("/coupon/i", $url)) { echo 'style="display:block;"';} ?>>
                <li <?php if(preg_match("/add-coupon/i", $url)) { echo 'class="active"';} ?>><a href="{{url('/admin/add-coupon')}}">Add Coupon</a></li>
                <li <?php if(preg_match("/view-coupons/i", $url)) { echo 'class="active"';} ?>><a href="{{url('/admin/view-coupons')}}">View Coupons</a></li>
            </ul>
        </li>

        <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Orders</span> </a>
            <ul <?php if(preg_match("/order/i", $url)) { echo 'style="display:block;"';} ?>>
                <li <?php if(preg_match("/view-orders/i", $url)) { echo 'class="active"';} ?>><a href="{{url('/admin/view-orders')}}">View Orders</a></li>
            </ul>
        </li>

        <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Banners</span> </a>
            <ul <?php if(preg_match("/banner/i", $url)) { echo 'style="display:block;"';} ?>>
                <li <?php if(preg_match("/add-banner/i", $url)) { echo 'class="active"';} ?>><a href="{{url('/admin/add-banner')}}">Add Banner</a></li>
                <li <?php if(preg_match("/view-banners/i", $url)) { echo 'class="active"';} ?>><a href="{{url('/admin/view-banners')}}">View Banner</a></li>
            </ul>
        </li>

    </ul>
</div>
<!--sidebar-menu-->