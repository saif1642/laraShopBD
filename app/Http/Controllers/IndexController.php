<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
class IndexController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('id','DESC')->get();
        $categories = Category::get();
        return view('index')->with(compact('products','categories'));
    }
}
