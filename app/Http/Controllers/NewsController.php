<?php

namespace App\Http\Controllers;

use App\Category;
use App\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{

    /**
     * Список категорий, с поддержкой вложенности
     */
    function categories() {
        $caterories = Category::getCaterorys();
        return view('news.caterorys', [
            'caterorys' => $caterories,
            'menu' => $caterories,
        ]);
    }

    /**
     * Одна категория
     * Сравниваем массив с путём
     */
    function category($full_path) {
        $caterorys = Category::getCaterorys();
        $arPath = explode('/', $full_path);

        for($i = 0; count($arPath) > $i; $i++) {
            $path = $arPath[$i];

            foreach ($caterorys as &$category) {

                if($category['alias'] === $path) {

                    if(count($arPath)-1 === $i) {

                        return view('news.category', [
                            'category' => $category,
                            'parent_path' => $full_path,
                            'news' =>  News::getNewsByCategory($category['alias']),
                            'menu' => Category::getCaterorys(),
                        ]);

                    }

                    if(isset($category['child'])) {
                        $caterorys = $category['child'];

                    }
                    break;
                }

            }

        }
        return abort(404);
    }

    /**
     * Новость
     */
    function news($id) {
        $article = News::find($id);

        if(!$article) {
            return abort(404);
        }

        return view('news.news', [
            'article' => $article,
            'menu' => Category::getCaterorys(),
        ]);
    }
}
