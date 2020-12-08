<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\article;

class ArticleController extends Controller
{
    function save_article(Request $request)
    {

        $article=new article;
        $article->article=$request->article;
        $article->save();
        return redirect()->back();
    }

    function get_article()
    {
        $data['get_article']=article::get();
        return $data['get_article'];
    }

    function delete_article(Request $request)
    {
        $delete_article=article::where('id',$request->id)->first();
        $delete_article->delete();
        return redirect()->back();

    }

    function edit_article(Request $request)
    {
        $edit_article=article::where('id',$request->id)->first();
        return $edit_article;
    }

    function edit_article_save(Request $request)
    {
        $save_article=article::where('id',$request->id)->first();
        $save_article->article=$request->article_val;
        $save_article->save();
        return "success";

    }


}
