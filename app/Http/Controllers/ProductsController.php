<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input; 
use Auth; 
use Session; 
use App\Category; 
use App\Product;
use Image; 

class ProductsController extends Controller
{
    public function addProduct(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<Pre>"; print_r($data);die;
            if(empty($data['category_id'])){
                return redirect()->back()->with('flash_message_error','Category not selected!!');
            }
            $product = new Product;
            $product->category_id = $data['category_id'];
            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_color = $data['product_color'];
            $product->price = $data['price'];
            if(!empty($data['description'])){
                $product->description = $data['description'];
            }else{
                $product->description = "";
            }
            //Image Upload
            if($request->hasFile('image')){
                $image_temp = Input::file('image');
                if($image_temp->isValid()){
                    $extension = $image_temp->getClientOriginalExtension();
                    $filename = rand(111,99999).'.'.$extension;
                    $largeImagePath = 'images/backend_images/products/large/'.$filename;
                    $mediumImagePath = 'images/backend_images/products/medium/'.$filename;
                    $smallImagePath = 'images/backend_images/products/small/'.$filename;

                    //Resize Image
                    Image::make($image_temp)->save($largeImagePath);
                    Image::make($image_temp)->resize(600,600)->save($mediumImagePath );
                    Image::make($image_temp)->resize(300,300)->save($smallImagePath);

                    //store image in product table
                    $product->image = $filename;
                }
                
            }
            
            $product->save();
            return redirect()->back()->with('flash_message_success','Product Added Successfully');
        }

        $categories = Category::where(['parent_id'=>0])->get();
        $categoryDropdownMenu = "<option selected disabled>Select</option>";
        foreach($categories as $cat){
            $categoryDropdownMenu .= "<option value='".$cat->id."'>".$cat->name."</option>";
            $subcategories = Category::where(['parent_id'=>$cat->id])->get();
            foreach($subcategories as $subcat){
                $categoryDropdownMenu .= "<option value='".$subcat->id."'>&nbsp; --&nbsp;".$subcat->name."</option>";
                
            }
            
        }

        return view('admin.products.add_product')->with(compact('categoryDropdownMenu'));
    }

    public function viewProducts(){
        $products = Product::get();
        foreach($products as $key => $val){
            $category = Category::where(['id'=>$val->category_id])->first();
            $products[$key]->category = $category->name;
        }
        return view('admin.products.view_products')->with(compact('products'));
    }
}
