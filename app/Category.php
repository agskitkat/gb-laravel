<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    protected $table = 'categories';

    // Расходуем ОЗУ...
    // Стриом иерархический массив категорий
    static function getCaterorys() {
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
        return DB::table('categories')
            ->where('alias', $alias)
            ->first();
    }
}
