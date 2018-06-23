<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Category;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public static function mainCategories(){
        $categories = Category::where(['parent_id'=>0])->get();
        $categories = json_decode( json_encode($categories), true);
        //echo "<pre>";print_r($mainCategories);die;
        return $categories;
    }
}
