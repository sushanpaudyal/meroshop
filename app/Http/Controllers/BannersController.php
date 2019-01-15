<?php

namespace App\Http\Controllers;

use App\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Image;
use File;

class BannersController extends Controller
{
    public function addBanner(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            $banner = new Banner;
            if($request->hasFile('image')){
                $image_tmp = Input::file('image');
                if($image_tmp->isValid()){
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(111,99999).'.'.$extension;
                    $banner_image_path = 'images/frontend_images/banners/'.$filename;
                    // Resize Image Code
                    Image::make($image_tmp)->resize(1140, 340)->save($banner_image_path);
                    // Store image name in products table
                    $banner->image = $filename;
                }
            }
            if(empty($data['status'])){
                $status = 0;
            } else {
                $status = 1;
            }

            $banner->status = $status;
            $banner->title = $data['title'];
            $banner->link = $data['link'];
            $banner->save();
            return redirect()->back()->with('flash_message_success', 'Banner Inserted Successfully');
        }
        return view ('admin.banners.add_banner');
    }

    public function viewBanner(){
        $banners = Banner::all();
        return view ('admin.banners.view_banners', compact('banners'));
    }

    public function editBanner(Request $request, $id = null){
        $bannerDetails = Banner::where('id', $id)->first();
        if($request->isMethod('post')){
            $data = $request->all();

            if($request->hasFile('image')){
                $image_tmp = Input::file('image');
                if($image_tmp->isValid()){
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(111,99999).'.'.$extension;
                    $banner_image_path = 'images/frontend_images/banners/'.$filename;
                    // Resize Image Code
                    Image::make($image_tmp)->resize(1140, 340)->save($banner_image_path);
                }
            } else {
                $filename = $data['current_image'];
            }

            if(empty($data['status'])){
                $status = 0;
            } else {
                $status = 1;
            }

            $bannerDetails->title = $data['title'];
            $bannerDetails->link = $data['link'];
            $bannerDetails->status = $data['status'];
            $bannerDetails->image = $filename;
            $bannerDetails->save();
            return redirect()->back()->with('flash_message_success', 'Banner Updates Successfully');


        }
        return view ('admin.banners.edit_banner', compact('bannerDetails'));
    }

    public function deleteBanner($id){
        Banner::where(['id' => $id])->delete();
        return redirect()->back()->with('flash_message_error', 'Banner Delete Successfully');
    }
}
