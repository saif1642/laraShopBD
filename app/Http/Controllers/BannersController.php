<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input; 
use App\Banner; 
use Image;

class BannersController extends Controller
{
    public function addBanner(Request $request){
              
        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<Pre>"; print_r($data);die;
            if(empty($data['status'])){
                $status = 0;
            }else{
                $status = 1;
            }
            $banner = new Banner;
            $banner->title = $data['title'];
            $banner->link = $data['link'];
            $banner->status = $status;

            //Image Upload
            if($request->hasFile('image')){
                $image_temp = Input::file('image');
                if($image_temp->isValid()){
                    $extension = $image_temp->getClientOriginalExtension();
                    $filename = rand(111,99999).'.'.$extension;
                    $bannerImagePath = 'images/backend_images/banner/'.$filename;

                    //Resize Image
                    Image::make($image_temp)->resize(1140,340)->save($bannerImagePath);

                    //store image in product table
                    $banner->image = $filename;
                }
                
            }
            
            $banner->save();
            return redirect()->back()->with('flash_message_success','Banner Added Successfully');
        }

        return view('admin.banner.add_banner');
    }
    public function viewBanners(){
        return view('admin.banner.view_banners')->with('banners',Banner::all());
    }
    public function editBanner($id = null,Request $request){
        $banner = Banner::find($id);
        if($request->isMethod('post')){
            $data = $request->all();
           // dd($data);
            if(empty($data['status'])){
                $status = 0;
            }else{
                $status = 1;
            }
            $banner->title = $data['title'];
            $banner->link = $data['link'];
            $banner->status = $status;

            //Image Upload
            if($request->hasFile('image')){
                $image_temp = Input::file('image');
                if($image_temp->isValid()){
                    $extension = $image_temp->getClientOriginalExtension();
                    $filename = rand(111,99999).'.'.$extension;
                    $bannerImagePath = 'images/backend_images/banner/'.$filename;

                    //Resize Image
                    Image::make($image_temp)->resize(1140,340)->save($bannerImagePath);

                    //store image in product table
                    $banner->image = $filename;
                }
                
            }else{
                $banner->image = $data['current_image'];
            }
            
            $banner->save();
            return redirect()->back()->with('flash_message_success','Banner Edited Successfully');
        }
        return view('admin.banner.edit_banner')->with('banner',$banner);
    }
    public function deleteBanner($id=null){
        $banner = Banner::find($id);
        $banner->delete();
        return redirect()->back()->with('flash_message_success','Banner Deleted Successfully');
    }
}
