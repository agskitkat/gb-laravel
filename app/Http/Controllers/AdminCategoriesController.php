<?php

namespace App\Http\Controllers;

use App\Category;
use App\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminCategoriesController extends Controller
{
    function index() {
        $list = Category::query()->paginate(env('PAGINATION', 10));

        return view('admin.categories.list', [
            'list' => $list
        ]);
    }

    function create() {
        $category = new Category();
        $categories = Category::getAllowedCategory($category);

        return view('admin.categories.edit', [
            'category'          =>  $category,
            'categoriesList'    =>  $categories,
            'menu'              =>  Category::getCaterorys()
        ]);
    }

    function edit(Category $category) {
        return view('admin.categories.edit', [
            'category'       =>     $category,
            'categoriesList' =>     Category::getAllowedCategory($category),
            'menu'           =>     Category::getCaterorys()
        ]);
    }

    function update(Request $request) {
        if(isset($request->id)) {
            $category = Category::query()->find($request->id);
        } else {
            $category = new Category();
        }

        $category->fill($request->all())->save();

        return view('admin.categories.edit', [
            'category'       =>     $category,
            'categoriesList' =>     Category::getAllowedCategory($category),
            'menu'           =>     Category::getCaterorys()
        ]);
    }

    function destroy(Category $category) {
        $category->delete();
        Session::flash('message', 'Категория удалена');
        return redirect()->route('articles.index');
    }
}
