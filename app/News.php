<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class News extends Model
{
    protected $table = 'news';

    static function getNewsByCategory($alias) {
        $category = Category::getCategoryByAlias($alias);
        $news = DB::table('news as n')
            ->select(['n.id', 'n.name', 'n.text'])
            ->join('category_news as cn', 'n.id', '=', 'cn.news_id')
            ->where('cn.category_id', '=', $category->id)
            ->get();

        return $news;
    }
}
