<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\catgeory;

class CategoryController extends Controller
{
    function category()
    {
        return view('category');
    }

    function save_all_category(Request $request)
    {
        foreach($request['group_category'] as $key=>$data)
        {
            $save_category = new catgeory;

            $save_category->category=$data;
            $save_category->save();
        }

        return redirect()->back();
    }
}
