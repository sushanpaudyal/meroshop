<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Session;

class CategoryController extends Controller
{
    public function addCategory(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            if(empty($data['status'])){
                $status = 0;
            } else {
                $status = 1;
            }

            $category = new Category;
            $category->name = $data['category_name'];
            $category->parent_id = $data['parent_id'];
            $category->description = $data['description'];
            $category->status = $status;
            $category->url = $data['url'];
            $category->save();
            return redirect('/admin/view-categories')->with('flash_message_success', 'Category Added Successfully');
        }
        $levels = Category::where(['parent_id' => 0])->get();
        return view ('admin.categories.add_category')->with(compact('levels'));
    }

    public function viewCategories()
    {
        $categories = Category::get();
        return view ('admin.categories.view_categories')->with(compact('categories'));
    }

    public function editCategory(Request $request, $id = null)
    {
        if($request->isMethod('post')){
            $data = $request->all();

            if(empty($data['status'])){
                $status = 0;
            } else {
                $status = 1;
            }

            Category::where(['id' => $id])->update(['name' => $data['category_name'], 'description' => $data['description'], 'url' => $data['url'], 'parent_id' => $data['parent_id'] , 'status' => $status
            ]);
            return redirect('/admin/view-categories')->with('flash_message_success', 'Category Successfully Updated');

        }
        $categoryDetails = Category::where(['id' => $id])->first();
        $levels = Category::where(['parent_id' => 0])->get();
        return view ('admin.categories.edit_category')->with(compact('categoryDetails', 'levels'));
    }


    public function deleteCategory($id = null){
        if(!empty($id)){
            Category::where(['id'=>$id])->delete();
            return redirect('/admin/view-categories')->with('flash_message_success', 'Category Successfully Deleted');
        }
    }
}
