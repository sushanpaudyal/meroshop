<?php

namespace App\Http\Controllers;

use App\Coupon;
use Illuminate\Http\Request;

class CouponsController extends Controller
{
    public function addCoupon(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            $coupon = new Coupon;
            $coupon->coupon_code = $data['coupon_code'];
            $coupon->amount = $data['amount'];
            $coupon->amount_type = $data['amount_type'];
            $coupon->expiry_date = $data['expiry_date'];
            $coupon->status = $data['status'];
            $coupon->save();
            return redirect()->route('view.coupon')->with('flash_message_success', 'Coupons Inserted Successfully');
         }
        return view ('admin.coupons.add_coupon');
    }

    public function viewCoupons(){
        $data = Coupon::latest()->get();
        return view('admin.coupons.view_coupons', compact('data'));
    }

    public function editCoupon(Request $request, $id = null){
        $couponDetails = Coupon::find($id);
        if($request->isMethod('post')){
            $data = $request->all();
            $coupon = Coupon::find($id);
            $coupon->coupon_code = $data['coupon_code'];
            $coupon->amount = $data['amount'];
            $coupon->amount_type = $data['amount_type'];
            $coupon->expiry_date = $data['expiry_date'];
            if(empty($data['status'])){
                $data['status'] = 0;
            }
            $coupon->status = $data['status'];
            $coupon->save();

            return redirect()->route('view.coupon')->with('flash_message_success', 'Coupons Updated Successfully');

        }
        return view ('admin.coupons.edit_coupon', compact('couponDetails'));
    }
}
