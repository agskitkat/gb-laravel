<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    protected $table = 'categories';
    public static $filename = 'categories.json';

    protected $fillable = [
        'name',
        'alias',
        'parent_id'
    ];

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

    static function getAllowedCategory($category) {
        $id = 0;

        if(isset($category->id)) {
            $id = $category->id;
        }

        $categories = Category::getCaterorys();

        $list = [];
        foreach($categories as $section) {
            $list = array_merge(
                $list,
                self::getSectionRecursion(
                    $section,
                    $id
                )
            );
        }
        return $list;
    }

    static function getSectionRecursion(&$section, &$excludeId = 0, $depth = 0) {
        $result = [];

        if(!$section || $section['id'] === $excludeId) {
            return [];
        }

        $result[] = [
            'id'    =>  $section['id'],
            'name'  =>  str_repeat('- ', $depth) . $section['name'],
            'alias' =>  $section['alias']
        ];

        if(isset($section['child'])) {
            $depth++;
            foreach ($section['child'] as $childSection) {
                $result = array_merge (
                    $result,
                    self::getSectionRecursion(
                        $childSection,
                        $excludeId,
                        $depth
                    )
                );
            }
        }

        return $result;
    }


}
