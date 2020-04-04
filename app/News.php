<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr\Array_;

class News extends Model
{
    protected $table = 'news';
    public static $filename = 'news.json';
    public static $filename_cn = 'news_cn.json';

    function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Миграция на файл
        if(!Storage::disk('local')->exists(self::$filename)) {

            $result = DB::table('news')->get();
            Storage::disk('local')->put(self::$filename, json_encode($result,JSON_UNESCAPED_UNICODE) );

            // да, модель связей должна быть, а тут две таблицы в модели
            $result = DB::table('category_news')->get();
            Storage::disk('local')->put(self::$filename_cn, json_encode($result,JSON_UNESCAPED_UNICODE) );
        }
    }

    // все новости категории
    static function getNewsByCategory($alias) {
        $category = Category::getCategoryByAlias($alias);
        $news = [];
        $cn = json_decode( Storage::disk('local')->get(self::$filename_cn) );

        // Эдакий условный join
        $selected_news = [];
        foreach ($cn as $cn_item) {
            if($cn_item->category_id === $category->id) {
                $selected_news[] = $cn_item->news_id;
            }
        }

        $articles = json_decode( Storage::disk('local')->get(self::$filename) );
        foreach($articles as &$article) {

            if(in_array($article->id, $selected_news)) {
                $news[] = $article;
            }
        }

        /*
        БД, все новости категории
          $news = DB::table('news as n')
            ->select(['n.id', 'n.name', 'n.text'])
            ->join('category_news as cn', 'n.id', '=', 'cn.news_id')
            ->where('cn.category_id', '=', $category->id)
            ->get();
        */

        return $news;
    }

    // Переопределяем поиск новости по ID
    static function find($id) {
        $articles = json_decode( Storage::disk('local')->get(self::$filename) );
        foreach($articles as &$article) {
            //echo $article->id . " - " . $id . PHP_EOL;
            if(+$id === +$article->id) {


                // Поддерживам актив рекорд, не хитрым способом XD
                // Всё это делается только для того что бы не трогать контроллеры,
                // и потом откатиться к БД
                $activeRecord = new News();

                $activeRecord->id = $article->id;
                $activeRecord->text = $article->text;
                $activeRecord->name = $article->name;

                return $activeRecord;
            }
        }
        return false;
    }

    // Список категорий статьи с флагом принодлежности
    function getCategorisSelectedList() {
        $id = $this->id?:0;
        $r = [];

        $cn = json_decode( Storage::disk('local')->get(self::$filename_cn) );
        $selected_categories_ids = [];
        foreach ($cn as $cn_item) {
            if($cn_item->news_id === $id) {
                $selected_categories_ids[] = $cn_item->category_id;
            }
        }

        $categories = json_decode( Storage::disk('local')->get(Category::$filename) );
        foreach($categories as &$category) {
            $category->is_use = in_array($category->id, $selected_categories_ids);
        }

        return $categories;
        /*
         БД, Список категорий статьи с флагом принодлежности
        return DB::table('categories as c')
            ->selectRaw('c.id id, c.name, (
                    SELECT COUNT(*) FROM category_news cn WHERE cn.news_id = '.$id.' AND cn.category_id = c.id
                ) is_use')
            ->get();
        */
    }

    // Метод save меняем на свой, файловый
    function save(array $options = []) {
        $articles = json_decode( Storage::disk('local')->get(self::$filename) );
        $flag_is_new = true;
        $max_id = 1;

        foreach ($articles as &$article) {
            $max_id = $max_id > +$article->id ?: +$article->id;
            if(+$article->id === +$this->id) {
                $flag_is_new = false;
                $article->text = $this->text;
                $article->name = $this->name;
            }
        }

        // Если новый элемент
        if($flag_is_new) {
            $article->id = $this->id = ++$max_id;
            $article->text = $this->text;
            $article->name = $this->name;
        }

        // Обновили файл
        Storage::disk('local')->put(self::$filename, json_encode($articles,JSON_UNESCAPED_UNICODE) );
    }


    function updateCategories(Array $ids = []) {

        $cn = json_decode( Storage::disk('local')->get(News::$filename_cn) );

        $max_id = 1;

        $cn_updeted = [];
        foreach ($cn as &$cn_item) {
            if($cn_item->news_id === $this->id) {

                foreach ($ids as $cat_key => &$cat_id) {
                    if($cat_id === $cn_item->category_id) {
                        $cn_updeted[] = $cn_item;
                        unset($ids[$cat_key]); // Ой-ёй
                    }
                }

            } else {
                $cn_updeted[] = $cn_item;
            }
            $max_id = $max_id > +$cn_item->id ?: +$cn_item->id;
        }

        if(count($ids)) {
            foreach($ids as $id) {
                $cn_updeted[] = [
                    "id" => ++$max_id,
                    "category_id" => $id,
                    "news_id" => $this->id
                ];
            }
        }

        Storage::disk('local')->put(self::$filename_cn, json_encode($cn_updeted,JSON_UNESCAPED_UNICODE) );
    }
}
