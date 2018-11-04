<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Coupon;
class CouponsController extends Controller
{
    public function addCoupon(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            //dd($data);
            $coupon = new Coupon;
            $coupon->coupon_code = $data['coupon_code'];
            $coupon->amount = $data['amount'];
            $coupon->amount_type = $data['amount_type'];
            $coupon->expiry_date = $data['expiry_date'];
            if(!isset($data['status'])){
                $coupon->status = 0;
            }else{
                $coupon->status=1;
            }
            $coupon->save();
            return redirect()->action('CouponsController@viewCoupons')->with('flash_message_success','Coupon Added Successfully');
        }
        return view('admin.coupons.add_coupon');
    }
    public function viewCoupons(){
        return view('admin.coupons.view_coupons')->with('coupons',Coupon::all());
    }
    public function editCoupon(Request $request,$id=null){

        if($request->isMethod('post')){
            $data = $request->all();
            //dd($data);
            $coupon = Coupon::find($id);
            $coupon->coupon_code = $data['coupon_code'];
            $coupon->amount = $data['amount'];
            $coupon->amount_type = $data['amount_type'];
            $coupon->expiry_date = $data['expiry_date'];
            if(!isset($data['status'])){
                $coupon->status = 0;
            }else{
                $coupon->status=1;
            }
            $coupon->save();
            return redirect()->action('CouponsController@viewCoupons')->with('flash_message_success','Coupon Edited Successfully');
        }
        return view('admin.coupons.edit_coupon')->with('coupon',Coupon::find($id));
        
    }

    public function deleteCoupon($id = null){
        Coupon::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success','Coupon Deleted Successfully');
    }
}
