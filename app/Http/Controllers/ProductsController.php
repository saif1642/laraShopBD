<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input; 
use Auth; 
use Session; 
use App\Category; 
use App\Product;
use App\ProductsAttribute;
use App\ProductImages;
use DB;
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
            if(empty($data['status'])){
                $status = 0;
            }else{
                $status = 1;
            }
            $product = new Product;
            $product->category_id = $data['category_id'];
            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_color = $data['product_color'];
            $product->status = $status;
            $product->price = $data['price'];
            if(!empty($data['description'])){
                $product->description = $data['description'];
            }else{
                $product->description = "";
            }
            if(!empty($data['care'])){
                $product->care = $data['care'];
            }else{
                $product->care = "";
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
            if(empty($data['status'])){
                $status = 0;
            }else{
                $status = 1;
            }

            if(empty($data['description'])){
                $data['description'] = "";
            }
            if(empty($data['care'])){
                $data['care'] = "";
            }
            if(empty($filename)){
                $filename = "noimage.png";
            }

            Product::where(['id'=>$id])->update(['category_id'=>$data['category_id'],'product_name'=>$data['product_name']
            ,'product_code'=>$data['product_code'],'product_color'=>$data['product_color'],'price'=>$data['price']
            ,'description'=>$data['description'],'care'=>$data['care'],'image'=>$filename,'status'=>$status]);

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
        $products = Product::orderBy('id','DESC')->get();
        foreach($products as $key => $val){
            $category = Category::where(['id'=>$val->category_id])->first();
            $products[$key]->category = $category->name;
        }
        return view('admin.products.view_products')->with(compact('products'));
    }

    public function deleteProductImage($id=null){

        //Get Product Image Name
        $productImage = Product::where(['id'=>$id])->first();

        //Get Product Image Path
        $largeImagePath = 'images/backend_images/products/large/';
        $mediumImagePath = 'images/backend_images/products/medium/';
        $smallImagePath = 'images/backend_images/products/small/';

        //Delete Large Image if not exists in folder
        if(file_exists($largeImagePath.$productImage->image)){
            unlink($largeImagePath.$productImage->image);
        }

        //Delete Medium Image if not exists in folder
        if(file_exists($mediumImagePath.$productImage->image)){
            unlink($mediumImagePath.$productImage->image);
        }

        //Delete small Image if not exists in folder
        if(file_exists($smallImagePath.$productImage->image)){
            unlink($smallImagePath.$productImage->image);
        }

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

                    //SKU Duplicate check
                    $attrCountSKU = ProductsAttribute::where('SKU',$val)->count();
                    if($attrCountSKU>0){
                        return redirect('admin/add-attributes/'.$id)->with('flash_message_error',' Duplicate SKU Attribute!!');
                    }

                     //SKU Duplicate check
                     $attrCountSize = ProductsAttribute::where(['product_id'=>$id,'size'=>$data['size'][$key]])->count();
                     if($attrCountSize>0){
                         return redirect('admin/add-attributes/'.$id)->with('flash_message_error','Duplicate Size for same Product!!');
                     }


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
        $product_attributes = ProductsAttribute::where('product_id',$id)->get();
        return view('admin.products.add_attributes')->with(compact('product_details','product_attributes'));
    }

    public function editAttributes(Request $request,$id = null){
        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>";print_r($data);die;
            foreach($data['attrIds'] as $key=>$attr){
                ProductsAttribute::where(['id'=>$data['attrIds'][$key]])->update(['price'=>$data['price'][$key],'stock'=>$data['stock'][$key]]);
            }
            return redirect()->back()->with('flash_message_success',' Product Attribues Updated Successfully');
        }
    }

    public function deleteAttributes($id = null){
        ProductsAttribute::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success',' Product Attributes deleted Successfully');
    }

    public function productWithCategoryURL($url = null){
        //Display 404 page
        $categoryCount = Category::where(['url'=>$url,'status'=>1])->count();
        //echo "<pre>";print_r($categoryCount);die;
        if($categoryCount==0){
            abort('404');
        }
        //get categories and subcategories
        $categories = Category::with('categories')->where(['parent_id'=>0])->get();
        $category = Category::where(['url'=>$url])->first();

        if($category->parent_id==0){
            //if the URL is main category url
            $subcategories = Category::where(['parent_id'=>$category->id])->get();
            //$cat_ids = "";
            foreach($subcategories as $subcat){
                $cat_ids[] = $subcat->id; 
            }
            //echo "<pre>";print_r($cat_ids);die;
            if(!empty($cat_ids)){
                $productInfo = Product::whereIn('category_id',$cat_ids)->get();
                $productInfo = json_decode(json_encode($productInfo));
            }else{
                $productInfo = Product::where(['category_id'=>$category->id])->get();
            }
            
            //echo "<pre>";print_r($productInfo);die;
        }else{
            //if the URL is sub category url
            $productInfo = Product::where(['category_id'=>$category->id])->get();
        }

       

        return view('products.listing')->with(compact('categories','category','productInfo'));
    }

    public function product($id = null){

        //Show 404 Page for disabled product id
        $productCount = Product::where(['id'=>$id,'status'=>1])->count();

        if($productCount == 0){
            abort(404);
        }


        $productDetail = Product::with('attributes')->where(['id'=>$id])->first();
        $productDetail = json_decode(json_encode($productDetail));

        //get related products
        $relatedProducts = Product::where('id','!=',$id)->where(['category_id'=>$productDetail->category_id])->get();
        //$relatedProducts = json_decode(json_encode($relatedProducts));
        //echo "<pre>";print_r($relatedProducts);die;
       
        //get categories and subcategories
        $categories = Category::with('categories')->where(['parent_id'=>0])->get();

         //Get Product Alternate Image
         $productImages = ProductImages::where(['product_id'=>$id])->get();
         
        //echo "<pre>";print_r($productImage);die;

        //Get total stock
        $total_stock = ProductsAttribute::where(['product_id'=>$id])->sum('stock');


        return view('products.detail')->with(compact('productDetail','categories','productImages','relatedProducts','total_stock'));

    }

    public function getProductPrice(Request $request){
        $data = $request->all();
        //echo "<pre>";print_r($data);die;

        $productArr = explode("-",$data['idSize']);
        //echo  $productArr[0]; echo $productArr[1];
        $productAttribute = ProductsAttribute::where(['product_id'=>$productArr[0],'size'=>$productArr[1]])->first();

        echo $productAttribute->price;
        echo '#';
        echo $productAttribute->stock;
    }

    public function addImages(Request $request,$id = null){
         $productDetail = Product::with('attributes')->where(['id'=>$id])->first();

         if($request->isMethod('post')){
             $data = $request->all();
             //echo "<pre>";print_r($data);die;
             if($request->hasFile('image')){

                $files = $request->file('image');
                //echo "<pre>";print_r($file);die;
                foreach($files as $file){

                    //Upload Image After Resize
                    $image = new ProductImages;
                    $extension = $file->getClientOriginalExtension();
                    $filename = rand(111,99999).'.'.$extension;

                    $largeImagePath = 'images/backend_images/products/large/'.$filename;
                    $mediumImagePath = 'images/backend_images/products/medium/'.$filename;
                    $smallImagePath = 'images/backend_images/products/small/'.$filename;

                    //Resize Image
                    Image::make($file)->save($largeImagePath);
                    Image::make($file)->resize(600,600)->save($mediumImagePath );
                    Image::make($file)->resize(300,300)->save($smallImagePath);

                    //store image in product_images table
                    $image->image = $filename;  
                    $image->product_id = $data['product_id'];
                    $image->save();
                }

            }          
            return redirect('admin/add-images/'.$id)->with('flash_message_success','Product Images Uploaded Successfully');
   
        }
        $productImages = ProductImages::where(['product_id'=>$id])->get();
        //echo "<pre>";print_r($productImages);die;

         return view('admin.products.add_images')->with(compact('productDetail','productImages'));
    }

    public function deleteAltImage($id=null){

        //Get Product Image Name
        $productImage = ProductImages::where(['id'=>$id])->first();

        //Get Product Image Path
        $largeImagePath = 'images/backend_images/products/large/';
        $mediumImagePath = 'images/backend_images/products/medium/';
        $smallImagePath = 'images/backend_images/products/small/';

        //Delete Large Image if not exists in folder
        if(file_exists($largeImagePath.$productImage->image)){
            unlink($largeImagePath.$productImage->image);
        }

        //Delete Medium Image if not exists in folder
        if(file_exists($mediumImagePath.$productImage->image)){
            unlink($mediumImagePath.$productImage->image);
        }

        //Delete small Image if not exists in folder
        if(file_exists($smallImagePath.$productImage->image)){
            unlink($smallImagePath.$productImage->image);
        }

        ProductImages::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success',' Product Alternate Image(s) Deleted Successfully');
    }

    public function addCart(Request $request){
        $data = $request->all();
        if(empty($data['user_email'])){
            $data['user_email']="";
        }
        $session_id = Session::get('session_id');
        if(empty($session_id)){
            $session_id = str_random(40); 
            Session::put('session_id',$session_id);
        } 
        $sizeArr = explode("-",$data['size']);
        DB::table('cart')->insert(['product_id'=>$data['product_id'],'product_name'=>$data['product_name'],
        'product_code'=>$data['product_code'],'product_color'=>$data['product_color'],'price'=>$data['price']
        ,'size'=>$sizeArr['1'],'quantity'=>$data['quantity'],'user_email'=>$data['user_email'],'session_id'=>$session_id]);
        //echo "<pre>";print_r($data);die;
        return redirect('cart')->with('flash_message_success','Product has been added in cart');
        
    }

    public function cart(){
        $session_id = Session::get('session_id'); 
        $userCart = DB::table('cart')->where(['session_id'=>$session_id])->get();
        //echo "<pre>";print_r($userCart);die;
        foreach($userCart as $key=>$product){
            $productDetails = Product::where('id',$product->product_id)->first();
            $userCart[$key]->image = $productDetails->image;
        }
        return view('products.cart')->with(compact('userCart')); 
    }

    public function deleteCartProduct($id = null){
        DB::table('cart')->where('id',$id)->delete();
        return redirect('cart')->with('flash_message_success','Item has been deleted from cart');
    }

   
    
}
