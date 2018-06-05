<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth; 
use Session; 
use App\Category; 
use App\Product;

class ProductsController extends Controller
{
    public function addProduct(Request $request){
        $categories = Category::where(['parent_id'=>0])->get();
        $categoryDropdownMenu = "<option selected disabled>Select</option>";
        foreach($categories as $cat){
            $categoryDropdownMenu .= "<option value='".$cat->id."'>&nbsp;~~&nbsp;".$cat->name."</option>";
            $subcategories = Category::where(['parent_id'=>$cat->id])->get();
            foreach($subcategories as $subcat){
                $categoryDropdownMenu .= "<option value='".$subcat->id."'>".$subcat->name."</option>";
                
            }
            
        }

        return view('admin.products.add_product')->with(compact('categoryDropdownMenu'));
    }
}
