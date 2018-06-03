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
        }
        return view('admin.categories.add_category');
    }
}
