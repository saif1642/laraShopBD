<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth; 
use Session; 
use App\Category; 
class CategoryController extends Controller
{
    public function addCategory(Request $request){
        if($request->isMethod('post')){
            $data=$request->all();


            if(empty($data['status'])){
                $status = 0;
            }else{
                $status = 1;
            }

            $category = new Category;
            $category->name = $data['cat_name'];
            $category->parent_id = $data['parent_id'];
            $category->description = $data['cat_description'];
            $category->url = $data['cat_url'];
            $category->status = $status;
            $category->save();
            return redirect('/admin/view-categories')->with('flash_message_success','Category Added Successfully');

        }
        $mainCategory = Category::where(['parent_id'=>0])->get();
        return view('admin.categories.add_category')->with(compact('mainCategory'));
    }
    public function editCategory(Request $request,$id=null){
        if($request->isMethod('post')){
            $data=$request->all();
            if(empty($data['status'])){
                $status = 0;
            }else{
                $status = 1;
            }
            Category::where(['id'=>$id])->update(['name'=>$data['cat_name'],'description'=>$data['cat_description'],
            'url'=>$data['cat_url'],'parent_id'=>$data['parent_id'],'status'=>$status]);
            return redirect('/admin/view-categories')->with('flash_message_success','Category Updated Successfully');
        }
        $categoryDetail = Category::where(['id'=>$id])->first();
        $mainCategory = Category::where(['parent_id'=>0])->get();
        return view('admin.categories.edit_category')->with(compact('categoryDetail','mainCategory'));
    }

    public function deleteCategory($id){
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
