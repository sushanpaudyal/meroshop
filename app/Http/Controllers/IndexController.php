<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;

class IndexController extends Controller
{
    public function index(){
        $productsAll = Product::orderBy('id', 'DESC')->get();
        // Getting all categories and sub categories
        $categories = Category::with('categories')->where(['parent_id' => 0])->get();
        // $categories = json_decode(json_encode($categories));
        // echo "<pre>"; print_r($categories); die;
        return view ('index')->with(compact('productsAll','categories'));
    }



}
