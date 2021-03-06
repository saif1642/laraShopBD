<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\Banner;
class IndexController extends Controller
{
    public function index()
    {
        $products = Product::get();
        $products = Product::orderBy('id','DESC')->get();
        $products = Product::inRandomOrder()->where('status',1)->get();
        //get All Categories
        $categories = Category::where(['parent_id'=>0])->get();

        //Get all Banners
        $banners = Banner::where('status',1)->get();
        
        return view('index')->with(compact('products','categories','banners'));
    }
}
