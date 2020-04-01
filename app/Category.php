<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // В данном, упращённом случае, нельза называть категории одинаково (alias)
    // alias = id - буквенный, хотя можно и численный
    private static $caterorys = [
        [
            'alias' => 'policy',
            'name'  => 'Политика',
            'child' => [
                [
                    'alias' => 'russia',
                    'name'  => 'Россия'
                ],[
                    'alias' => 'usa',
                    'name'  => 'Сша'
                ],[
                    'alias' => 'europe',
                    'name'  => 'Европа',
                    'child' => [
                        [
                            'alias' => 'france',
                            'name'  => 'Франция'
                        ], [
                            'alias' => 'germany',
                            'name'  => 'Германия'
                        ],
                    ]
                ],
            ]
        ],
        [
            'alias' => 'hitech',
            'name'  => 'Технологии',
            'child' => [
                [
                    'alias' => 'pc',
                    'name'  => 'Компьютеры',
                ],[
                    'alias' => 'mobile',
                    'name'  => 'Смартфоны',
                ]
            ]
        ],
        [
            'alias' => 'ecology',
            'name'  => 'Экология',
        ]
    ];


    static function getCaterorys() {
        return self::$caterorys;
    }

}
