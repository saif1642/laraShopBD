<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    public function addCategory(Request $request){
        if($request->isMethod('post')){
            $data=$request->all();
            $category = new Category;
            $category->name = $data['cat_name'];
            $category->description = $data['cat_description'];
            $category->url = $data['cat_url'];
            $category->save();
            return redirect('/admin/view-categories')->with('flash_message_success','Category Added Successfully');

        }
        return view('admin.categories.add_category');
    }
    public function editCategory(Request $request,$id=null){
        if($request->isMethod('post')){
            $data=$request->all();
            Category::where(['id'=>$id])->update(['name'=>$data['cat_name'],'description'=>$data['cat_description'],'url'=>$data['cat_url']]);
            return redirect('/admin/view-categories')->with('flash_message_success','Category Updated Successfully');
        }
        $categoryDetail = Category::where(['id'=>$id])->first();
        return view('admin.categories.edit_category')->with(compact('categoryDetail'));
    }

    public function deleteCategory($id=null){
        if(!empty($id)){
            Category::where(['id'=>$id])->delete();
            return redirect()->back()->with('flash_message_success','Category Deleted Successfully');
        }
    }


    public function viewCategories(){
        $categories = Category::get();
        return view('admin.categories.view_categories')->with(compact('categories'));
    }
}
