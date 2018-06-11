<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input; 
use Auth; 
use Session; 
use App\Category; 
use App\Product;
use App\ProductsAttribute;
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

    public function editProduct(Request $request ,$id=null){
      
        $product_details = Product::where(['id'=>$id])->first();
        
        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<Pre>"; print_r($data);die;
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

                }else{
                    $filename = $data['current_image'];
                }
                
            }

            if(empty($data['description'])){
                $data['description'] = "";
            }
            

            Product::where(['id'=>$id])->update(['category_id'=>$data['category_id'],'product_name'=>$data['product_name']
            ,'product_code'=>$data['product_code'],'product_color'=>$data['product_color'],'price'=>$data['price']
            ,'description'=>$data['description'],'image'=>$filename]);

            return redirect()->back()->with('flash_message_success','Product Updated Successfully');
        }



         //Category Dropdown Menu
        $categories = Category::where(['parent_id'=>0])->get();
        $categoryDropdownMenu = "<option selected disabled>Select</option>";
        foreach($categories as $cat){
            if($cat->id == $product_details->category_id){
                $selected = "selected";
            }else{
                $selected = "";
            }
            $categoryDropdownMenu .= "<option value='".$cat->id."' ".$selected.">".$cat->name."</option>";
            $subcategories = Category::where(['parent_id'=>$cat->id])->get();
            foreach($subcategories as $subcat){
                if($subcat->id == $product_details->category_id){
                    $selected = "selected";
                }else{
                    $selected = "";
                }
                $categoryDropdownMenu .= "<option value='".$subcat->id."' ".$selected.">&nbsp; --&nbsp;".$subcat->name."</option>";
                
            }
            
        }

        return view('admin.products.edit_product')->with(compact('product_details','categoryDropdownMenu'));
    }
    public function viewProducts(){
        $products = Product::get();
        foreach($products as $key => $val){
            $category = Category::where(['id'=>$val->category_id])->first();
            $products[$key]->category = $category->name;
        }
        return view('admin.products.view_products')->with(compact('products'));
    }

    public function deleteProductImage($id=null){
        Product::where(['id'=>$id])->update(['image'=>'']);
        return redirect()->back()->with('flash_message_success',' Product Image Deleted Successfully');
    }

    public function deleteProduct($id = null){
        Product::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success',' Product Deleted Successfully');
    }

    public function addAttributes (Request $request ,$id = null){
        $product_details = Product::where(['id'=>$id])->first();
        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<Pre>"; print_r($data);die;
            foreach($data['sku'] as $key => $val){
                if(!empty($val)){
                    $attribute = new ProductsAttribute;
                    $attribute->sku = $val;
                    $attribute->product_id = $id;
                    $attribute->size = $data['size'][$key];
                    $attribute->price = $data['price'][$key];
                    $attribute->stock = $data['stock'][$key];
                    $attribute->save();
                }
            }
            return redirect('admin/add-attributes/'.$id)->with('flash_message_success',' Product Attribues added Successfully');

        }
        $product_attributes = ProductsAttribute::get();
        return view('admin.products.add_attributes')->with(compact('product_details','product_attributes'));
    }

    public function deleteAttributes($id = null){
        ProductsAttribute::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success',' Product Attributes deleted Successfully');
    }

    
}