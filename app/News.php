<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class News extends Model
{
    protected $table = 'news';

    protected $fillable = [
        'name',
        'text',
        'alias',
        'image'
    ];

    public $categories = [];

    // все новости категории
    static function getNewsByCategory($alias) {
        $category = Category::getCategoryByAlias($alias);

        //БД, все новости категории
          $news = DB::table('news as n')
            ->select(['n.id', 'n.name', 'n.text', 'n.image'])
            ->join('category_news as cn', 'n.id', '=', 'cn.news_id')
            ->where('cn.category_id', '=', $category->id)
            ->paginate(env('PAGINATION', 10));

        return $news;
    }

    // Список категорий статьи с флагом принодлежности
    function getCategorisSelectedList() {
        $id = $this->id?:0;

        // БД, Список категорий статьи с флагом принодлежности
        /*
         * Вижу прямые запросы в БД через selectRaw, нужно по возможности избегать таких запросов и все строить через
         * кноструктор запросов, не такой он уж там и сложный был
         * SELECT COUNT(*) FROM category_news cn WHERE cn.news_id = '.$id.' AND cn.category_id = c.id
         * И даже излишен, вполне достаточно только по id новости доставать запись,
         *  зачем еще и по категории то? Лишняя нагрузка на БД.
         *
         * В данном случае, я пытаюсь получить список всех категорий с
         * флагом о принодлжности конкретной записи к конкретной категории
         * через промежуточную таблицу.
         * Как это сделать по ID новости я так понять и не смог (
         */
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
                /*
                 * Как-то переусложняете, если то-же можно сделать проще, лучше пойти по этому пути.

                    Вот например какая-то логика с запросом в цикле
                    foreach ($ids as $id) {
                    DB::table('category_news')

                 * Уже не вникая сразу могу сказать что так не нужно, запросы в цикле зло,
                 * и лучше одним запросом сделать или пересмотреть логику работы.

                // Было
                foreach ($ids as $id) {
                    DB::table('category_news')
                        ->updateOrInsert(
                            ['category_id' => $id, 'news_id' => $this->id],
                            ['category_id' => $id, 'news_id' => $this->id]
                        );
                }
                */

                // Стало
                $insert = [];
                foreach ($ids as $id) {
                    $insert[] = [
                        'category_id' => $id,
                        'news_id' => $this->id
                    ];
                }
                DB::table('category_news')->insert($insert);
            }

            DB::commit();

        } catch (\Exception $exception) {
            DB::rollBack();
        }

    }

    static function rules() {
        $newsTableName = (new News())->getTable();
        $categoryTableName = (new Category())->getTable();
        return [
            'name'      =>  'required|min:3|max:255',
            'text'      =>  'required|min:100',
            'alias'     =>  "unique:$newsTableName,alias",
            'categories' => "required|array",
            'categories.*' => "required|string|distinct|exists:$categoryTableName,id",
        ];
    }

    static function rulesNames() {
        return [
            'name'          => 'Заголовок',
            'text'          => 'Текст новости',
            'categories'    => 'Категория'
        ];
    }
}
