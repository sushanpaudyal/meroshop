<?php

namespace App\Http\Controllers;

use App\Banner;
use Illuminate\Http\Request;
use App\Product;
use App\Category;

class IndexController extends Controller
{
    public function index(){
        $productsAll = Product::orderBy('id', 'DESC')->where('status','=', 1)->get();
        // Getting all categories and sub categories
        $categories = Category::with('categories')->where(['parent_id' => 0])->get();
        // $categories = json_decode(json_encode($categories));
        // echo "<pre>"; print_r($categories); die;

        $banners = Banner::where('status', '1')->get();
        return view ('index')->with(compact('productsAll','categories', 'banners'));
    }



}
