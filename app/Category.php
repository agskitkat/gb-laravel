<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    protected $table = 'categories';
    public static $filename = 'categories.json';


    // Расходуем ОЗУ...
    // Стриом иерархический массив категорий
    static function getCaterorys() {

        // Миграция на файл
        /*if(!Storage::disk('local')->exists(self::$filename)) {
            // БД
            $result = DB::table('categories')->get();
            Storage::disk('local')->put(self::$filename, json_encode($result,JSON_UNESCAPED_UNICODE) );
        }*/

        // Использование файла как бд
        //$result = json_decode( Storage::disk('local')->get(self::$filename) );

        $result = DB::table('categories')->get();

        // Немного удобства, но можно и без него.
        $dataset = [];
        foreach($result as &$val) {
            $dataset[$val->id] = (array) $val;
        }

        // Построение древа категорий
        $tree = array();
        foreach ($dataset as &$node) {
            $id = &$node['id'];
            if (!$node['parent_id']) {
                $tree[$id] = &$node;
            } else {
                $dataset[$node['parent_id']]['child'][$id] = &$node;
            }
        }
        return $tree;
    }

    static function getCategoryByAlias($alias) {
        // Использование файла как бд
        /*$categories = json_decode( Storage::disk('local')->get(self::$filename) );

        // Поиск по фалу
        foreach($categories as &$category) {
            if($category->alias === $alias) {
                //dd($category);
                return $category;
            }
        }
        return [];*/

        // Возврат к бд

        return DB::table('categories')
            ->where('alias', $alias)
            ->first();

    }
}
