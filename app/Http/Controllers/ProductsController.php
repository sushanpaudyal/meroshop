<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\ProductsImage;
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

            if(!empty($data['care'])){
                $product->care = $data['care'];
            } else {
                $product->care = '';
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

            if(empty($data['status'])){
                $status = 0;
            } else {
                $status = 1;
            }
            $product->status = $status;

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

            if(empty($data['status'])){
                $status = 0;
            } else {
                $status = 1;
            }

            Product::where(['id'=>$id])->update(['category_id' => $data['category_id'],'product_name' => $data['product_name'],'product_code' => $data['product_code'],'product_color' => $data['product_color'],'description' => $data['description'], 'care' => $data['care'] , 'status' => $status,  'price' => $data['price'], 'image'=>$filename
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
//        Get Product Image Name
        $productImage = Product::where(['id' => $id])->first();

//        Get Product Image Paths

        $large_image_path = 'images/backend_images/products/large/';
        $medium_image_path = 'images/backend_images/products/medium/';
        $small_image_path = 'images/backend_images/products/small/';

        if(file_exists($large_image_path.$productImage->image)){
            unlink($large_image_path.$productImage->image);
        }
        if(file_exists($medium_image_path.$productImage->image)){
            unlink($medium_image_path.$productImage->image);
        }
        if(file_exists($small_image_path.$productImage->image)){
            unlink($small_image_path.$productImage->image);
        }

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

                     // SKU Check
                    $attrCountSKU = ProductAttribute::where('sku', $val)->count();
                    if($attrCountSKU > 0){
                        return redirect('/admin/add-attribute/'.$id)->with('flash_message_error', 'SKU Already Exists');
                    }
                    // Size Check
                    $attrCountSizes = ProductAttribute::where(['product_id' => $id, 'size' => $data['size'][$key]])->count();
                    if($attrCountSizes > 0){
                        return redirect('/admin/add-attribute/'.$id)->with('flash_message_error', ' "'.$data['size'][$key].' Size Already Exists');
                    }

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


    public function addImages(Request $request, $id = null){
        $productDetails = Product::with('attributes')->where(['id'=>$id])->first();


        if($request->isMethod('post')){
            $data = $request->all();
//            echo "<pre>"; print_r($data); die;
            if($request->hasFile('image')){
                $files = $request->file('image');
                foreach($files as $file){
                    $image = new ProductsImage;
                    $extension = $file->getClientOriginalExtension();
                    $filename = rand(111,99999).'.'.$extension;

                    $large_image_path = 'images/backend_images/products/large/'.$filename;
                    $medium_image_path = 'images/backend_images/products/medium/'.$filename;
                    $small_image_path = 'images/backend_images/products/small/'.$filename;
                    Image::make($file)->save($large_image_path);
                    Image::make($file)->resize(600,600)->save($medium_image_path);
                    Image::make($file)->resize(300,300)->save($small_image_path);
                    $image->image = $filename;
                    $image->product_id = $data['product_id'];
                    $image->save();
                }

            }
            return redirect('admin/add-images/'.$id)->with('flash_message_success', 'Images Hass Been Added Successfully');
        }

        $productsImages = ProductsImage::where(['product_id' => $id])->get();
        return view ('admin.products.add_images')->with(compact('productDetails', 'productsImages'));
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
            $productsAll = Product::whereIn('category_id',$cat_ids)->where('status', 1)->get();
            $productsAll = json_decode(json_encode($productsAll));
        } else {
            // if url is subcategory url
            $productsAll = Product::where(['category_id' => $categoryDetails->id])->get();
        }
        return view ('products.listing')->with(compact('categoryDetails','productsAll','categories'));
    }


    public function product($id = null){
//        Show 404 Page if product is disabled
        $productsCount = Product::where(['id' => $id, 'status' => 1])->count();
        if($productsCount ==0){
            abort(404);
        }

        $productDetails = Product::with('attributes')->where('id', $id)->first();
        $categories = Category::with('categories')->where(['parent_id' => 0])->get();


        $relatedProducts = Product::where('id', '!=', $id)->where(['category_id' => $productDetails->category_id])->get();


        $productAltImages = ProductsImage::where(['product_id' => $id])->get();

         $total_stock = ProductAttribute::where('product_id', $id)->sum('stock');

        return view ('products.detail')->with(compact('productDetails', 'categories', 'productAltImages', 'total_stock', 'relatedProducts'));
    }

    public function getProductPrice(Request $request){
        $data = $request->all();
//        echo "<pre>"; print_r($data); die;
        $proArr = explode("-", $data['idSize']);
        $proAttr = ProductAttribute::where(['product_id' => $proArr[0], 'size' => $proArr[1]])->first();
        echo $proAttr->price;
        echo "#";
        echo $proAttr->stock;
    }

    public function deleteAltImage($id = null){
        $productImage = ProductsImage::where(['id' => $id])->first();


        $large_image_path = 'images/backend_images/products/large/';
        $medium_image_path = 'images/backend_images/products/medium/';
        $small_image_path = 'images/backend_images/products/small/';

        if(file_exists($large_image_path.$productImage->image)){
            unlink($large_image_path.$productImage->image);
        }
        if(file_exists($medium_image_path.$productImage->image)){
            unlink($medium_image_path.$productImage->image);
        }
        if(file_exists($small_image_path.$productImage->image)){
            unlink($small_image_path.$productImage->image);
        }

        ProductsImage::where(['id' => $id])->delete();
        return redirect()->back()->with('flash_message_success', 'Product Alternate Image has been Deleted successfully');
    }

    public function editAttributes(Request $request, $id = null){
        if($request->isMethod('post')){
            $data = $request->all();
//            echo "<pre>"; print_r($data); die;

            foreach($data['idAttr'] as $key => $attr){
                ProductAttribute::where(['id' => $data['idAttr'][$key]])->update(['price' => $data['price'][$key], 'stock' => $data['stock'][$key]]);
            }
            return redirect()->back()->with('flash_message_success', 'Products Attributes Updated Successfully');
        }
    }



}
