<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\News;
use Illuminate\Support\Facades\Storage;

class AdminArticelController extends Controller
{
    //
    function edit($id = false) {

        if($id) {
            $article = News::find($id);

            if(!$article) {
                return abort(404);
            }

        } else {
            $article = new News();
        }

        return view('admin.editArticle', [
            'article' => $article,
            'categoriesList' => $article->getCategorisSelectedList(),
            'menu' => Category::getCaterorys()
        ]);
    }


    function save(Request $request) {

        //dd($request->categories);

        if($request->id) {
            $article = News::find($request->id);
            if(!$article) {
                return abort(404);
            }
        } else {
            $article = new News();
        }


        $article->name = $request->name;
        $article->text = $request->text;
        $article->save();

        //обновляем связи категорий и новостей
        $article->updateCategories($request->categories);


       return redirect()->route('admin.article.edit', [$article->id]);
    }

}
