<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Session;
use Image;
use App\ProductAttribute;
class ProductsController extends Controller
{
    public function addProduct(Request $request){

        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            if(empty($data['category_id'])){
                return redirect()->back()->with('flash_message_error', 'Under Category is misisng');
            }
            $product = new Product;
            $product->category_id = $data['category_id'];
            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_color = $data['product_color'];
            if(!empty($data['description'])){
                $product->description = $data['description'];
            } else {
                $product->description = '';
            }
            $product->price = $data['price'];
            // upload image
            if($request->hasFile('image')){
                $image_tmp = Input::file('image');
                if($image_tmp->isValid()){
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(111,99999).'.'.$extension;
                    $large_image_path = 'images/backend_images/products/large/'.$filename;
                    $medium_image_path = 'images/backend_images/products/medium/'.$filename;
                    $small_image_path = 'images/backend_images/products/small/'.$filename;
                    // Resize Image Code
                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->resize(600,600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(300,300)->save($small_image_path);
                    // Store image name in products table
                    $product->image = $filename;
                }
            }

            $product->save();
            return redirect('admin/view-products')->with('flash_message_success', 'Product Has been added successfully');
        }

        $categories = Category::where(['parent_id' => 0])->get();
        $categories_dropdown = "<option value='' selected disabled>  Select </option>";
        foreach($categories as $cat){
            $categories_dropdown .= "<option value ='".$cat->id."'>".$cat->name."</option>";
            $sub_categories = Category::where(['parent_id' => $cat->id])->get();
            foreach ($sub_categories as $sub_cat) {
                $categories_dropdown .= "<option value= '".$sub_cat->id."'>&nbsp;--&nbsp;".$sub_cat->name."</option>";
            }
        }
        return view ('admin.products.add_product')->with(compact('categories_dropdown'));

    }



    public function viewProducts(){
        $products = Product::get();
        foreach($products as $key => $val){
            $category_name = Category::where(['id'=>$val->category_id])->first();
            $products[$key]->category_name = $category_name->name;
        }
        return view('admin.products.view_products')->with(compact('products'));
    }


    public function editProduct(Request $request, $id = null){
        if($request->isMethod('post')){
            $data = $request->all();
            if($request->hasFile('image')){
                $image_tmp = Input::file('image');
                if($image_tmp->isValid()){
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(111,99999).'.'.$extension;
                    $large_image_path = 'images/backend_images/products/large/'.$filename;
                    $medium_image_path = 'images/backend_images/products/medium/'.$filename;
                    $small_image_path = 'images/backend_images/products/small/'.$filename;
                    // Resize Image Code
                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->resize(600,600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(300,300)->save($small_image_path);
                }
            } else {
                $filename = $data['current_image'];
            }
            if(empty($data['description'])){
                $data['description'] = "";
            }

            Product::where(['id'=>$id])->update(['category_id' => $data['category_id'],'product_name' => $data['product_name'],'product_code' => $data['product_code'],'product_color' => $data['product_color'],'description' => $data['description'], 'price' => $data['price'], 'image'=>$filename
            ]);

            return redirect()->back()->with('flash_message_success', 'Product Has been updated successfully');
        }

        $productDetails = Product::where(['id' => $id])->first();
        $categories = Category::where(['parent_id' => 0])->get();
        $categories_dropdown = "<option value='' selected disabled>  Select </option>";
        foreach($categories as $cat){
            if($cat->id == $productDetails->category_id){
                $selected = "selected";
            } else {
                $selected = "";
            }
            $categories_dropdown .= "<option value ='".$cat->id."' ".$selected.">".$cat->name."</option>";
            $sub_categories = Category::where(['parent_id' => $cat->id])->get();
            foreach ($sub_categories as $sub_cat) {
                if($sub_cat->id == $productDetails->category_id){
                    $selected = "selected";
                } else {
                    $selected = "";
                }
                $categories_dropdown .= "<option value= '".$sub_cat->id."' ".$selected." >&nbsp;--&nbsp;".$sub_cat->name."</option>";
            }
        }
        return view ('admin.products.edit_product')->with(compact('productDetails','categories_dropdown'));
    }



    public function deleteProductImage($id = null){
        Product::where(['id' => $id])->update(['image' => '']);
        return redirect()->back()->with('flash_message_success', 'Product Image has been Deleted successfully');
    }

    public function deleteProduct($id = null){
        Product::where(['id' => $id])->delete();
        return redirect('/admin/view-products')->with('flash_message_success', 'Product has been Deleted successfully');
    }




    public function addAttributes(Request $request, $id = null){
        $productDetails = Product::with('attributes')->where(['id'=>$id])->first();
        // $productDetails = json_decode(json_encode($productDetails));
        // echo "<pre>"; print_r($productDetails); die;

        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            foreach($data['sku'] as $key => $val){
                if(!empty($val)){
                    $attribute = new ProductAttribute;
                    $attribute->product_id = $id;
                    $attribute->sku = $val;
                    $attribute->size = $data['size'][$key];
                    $attribute->price = $data['price'][$key];
                    $attribute->stock = $data['stock'][$key];
                    $attribute->save();
                }
            }
            return redirect('/admin/add-attribute/'.$id)->with('flash_message_success', 'Attribute added successfully');
        }
        return view ('admin.products.add_attributes')->with(compact('productDetails'));
    }




    public function deleteAttribute($id = null){
        ProductAttribute::where(['id' => $id])->delete();
        return redirect()->back()->with('flash_message_success', 'Attribute Delete successfully');
    }

    public function products($url = null){

        //show 404 page if category url does not exist
        $countCategory = Category::where(['url'=> $url, 'status' => 1])->count();
        if($countCategory == 0){
            abort(404);
        }


        // Getting all categories and sub categories
        $categories = Category::with('categories')->where(['parent_id' => 0])->get();

        $categoryDetails = Category::where(['url' => $url])->first();
        if($categoryDetails->parent_id == 0){
            // if url is main category
            $subCategories = Category::where(['parent_id' => $categoryDetails->id])->get();
            foreach($subCategories as  $subcat){
                $cat_ids[] = $subcat->id;
            }
            $productsAll = Product::whereIn('category_id',$cat_ids)->get();
            $productsAll = json_decode(json_encode($productsAll));
        } else {
            // if url is subcategory url
            $productsAll = Product::where(['category_id' => $categoryDetails->id])->get();
        }
        return view ('products.listing')->with(compact('categoryDetails','productsAll','categories'));
    }




}
