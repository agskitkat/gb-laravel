<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class News extends Model
{
    protected $table = 'news';
    public static $filename = 'news.json';
    public static $filename_cn = 'news_cn.json';

    function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    // все новости категории
    static function getNewsByCategory($alias) {
        $category = Category::getCategoryByAlias($alias);



        //БД, все новости категории
          $news = DB::table('news as n')
            ->select(['n.id', 'n.name', 'n.text', 'n.image'])
            ->join('category_news as cn', 'n.id', '=', 'cn.news_id')
            ->where('cn.category_id', '=', $category->id)
            ->get();


        return $news;
    }



    // Список категорий статьи с флагом принодлежности
    function getCategorisSelectedList() {
        $id = $this->id?:0;

        /*$r = [];

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
         */

        // БД, Список категорий статьи с флагом принодлежности
        return DB::table('categories as c')
            ->selectRaw('c.id id, c.name, (
                    SELECT COUNT(*) FROM category_news cn WHERE cn.news_id = '.$id.' AND cn.category_id = c.id
                ) is_use')
            ->get();

    }



    function updateCategories(Array $ids = []) {

        DB::beginTransaction();

        try {
            DB::table('category_news')
                ->where('news_id', '=', $this->id)
                ->delete();

            if(count($ids)) {
                foreach ($ids as $id) {
                    DB::table('category_news')
                        ->updateOrInsert(
                            ['category_id' => $id, 'news_id' => $this->id],
                            ['category_id' => $id, 'news_id' => $this->id]
                        );
                }
            }

            DB::commit();

        } catch (\Exception $exception) {
            DB::rollBack();
        }

    }
}
