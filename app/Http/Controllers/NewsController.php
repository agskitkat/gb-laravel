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
        return view('news.caterorys', [
            'caterorys' =>  Category::getCaterorys(),
        ]);
    }

    /**
     * Одна категория
     * Сравниваем массив с путём
     */
    function category($full_path) {
        $caterorys = Category::getCaterorys();
        $arPath = explode('/', $full_path);
        //
        //print_r($arPath);

        for($i = 0; count($arPath) > $i; $i++) {
            $path = $arPath[$i];

            foreach ($caterorys as &$category) {
                //echo $category['alias'] ." - ". $path. PHP_EOL;

                if($category['alias'] === $path) {

                    //echo count($arPath)-1 ."-". $i. PHP_EOL;

                    if(count($arPath)-1 === $i) {

                        return view('news.category', [
                            'category' => $category,
                            'parent_path' => $full_path,
                            'news' =>  News::getNewsByCategory($category['alias'])
                        ]);

                    }

                    //echo "DOWN ". PHP_EOL;
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
        $article = News::getArticelById($id);

        if(!$article) {
            return abort(404);
        }

        return view('news.news', [
            'article' => $article
        ]);
    }
}
