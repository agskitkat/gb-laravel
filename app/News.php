<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{

    private static $news = [
        1 => [
            'id' => 1,
            'title' => 'Новость 1',
            'text' => 'А у нас новость 1 и она очень хорошая!'
        ],
        2 => [
            'id' => 2,
            'title' => 'Новость 2',
            'text' => 'А тут плохие новости((('
        ],
        3 => [
            'id' => 3,
            'title' => 'Новость про ПК',
            'text' => 'Новые компы, мощнее старых, но дороже !'
        ],
        4 => [
            'id' => 4,
            'title' => 'Новость про Экологию',
            'text' => 'Нефти нет, переходим на уголь.'
        ]
    ];

    // Связи категорий со статьями
    private static $news_in_caterory = [
        'policy'    => [1,2,3,4],
        'russia'    => [2],
        'hitech'    => [3],
        'ecology'   => [4],
    ];

    static function getNewsByCategory($alias) {
        if(!isset(self::$news_in_caterory[$alias])) {
            return [];
        }

        $return = [];
        foreach(self::$news_in_caterory[$alias] as $newsId) {
            $return[$newsId] = self::$news[$newsId];
        }

        return $return;
    }

    static function getArticelById($id) {
        return isset(self::$news[$id]) ? self::$news[$id] : false;
    }
}
