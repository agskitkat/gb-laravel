<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\News;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminArticelController extends Controller
{
    function index() {
        $list = News::query()->paginate(env('PAGINATION', 10));

        return view('admin.articles.list', [
            'list' => $list
        ]);
    }

    function create() {
        $article = new News();

        return view('admin.articles.editArticle', [
            'article' => $article,
            'categoriesList' => $article->getCategorisSelectedList(),
            'menu' => Category::getCaterorys()
        ]);
    }

    function edit(News $article) {

        return view('admin.articles.editArticle', [
            'article' => $article,
            'categoriesList' => $article->getCategorisSelectedList(),
            'menu' => Category::getCaterorys()
        ]);
    }

    function update(Request $request) {
        if($request->id) {
            $article = News::find($request->id);
            if(!$article) {
                return abort(404);
            }
        } else {
            $article = new News();
        }

        $article->fill($request->all());
        $article->alias = Str::slug($request->name);

        if($request->file('image')) {
            $path = $request->file('image')->store('public/image');
            $article->image = Storage::url($path);
        }

        $article->save();

        //обновляем связи категорий и новостей
        $article->updateCategories($request->categories);

        Session::flash('message', 'Изменения сохранены !');

        return redirect()->route('articles.edit',[ $article->id]);
    }

    function destroy(News $article) {
        $article->delete();
        Session::flash('message', 'Статья удалена');
        return redirect()->route('articles.index');
    }

}
