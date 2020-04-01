<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class News extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Категории
        $section_id_1 = DB::table('categories')->insertGetId([
            'name' => "Политика",
            'alias' => 'policy',
            'parent_id' => null,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('categories')->insertGetId([
            'name' => "Россия",
            'alias' => 'russia',
            'parent_id' => $section_id_1,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('categories')->insertGetId([
            'name' => "Сша",
            'alias' => 'usa',
            'parent_id' => $section_id_1,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $europe_id = DB::table('categories')->insertGetId([
            'name' => "Европа",
            'alias' => 'europe',
            'parent_id' => $section_id_1,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('categories')->insertGetId([
            'name' => "Франция",
            'alias' => 'france',
            'parent_id' => $europe_id,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $germany_id = DB::table('categories')->insertGetId([
            'name' => "Германия",
            'alias' => 'germany',
            'parent_id' => $europe_id,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $section_id_2 = DB::table('categories')->insertGetId([
            'name' => "Технологии",
            'alias' => 'hitech',
            'parent_id' => null,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        $section_pc = DB::table('categories')->insertGetId([
            'name' => "Компьютеры",
            'alias' => 'pc',
            'parent_id' => $section_id_2,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('categories')->insertGetId([
            'name' => "Смартфоны",
            'alias' => 'mobile',
            'parent_id' => $section_id_2,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $section_id_3 = DB::table('categories')->insertGetId([
            'name' => "Экология",
            'alias' => 'ecology',
            'parent_id' => null,
            'created_at' => date('Y-m-d H:i:s')
        ]);




        // Новости
        $news_1 = DB::table('news')->insertGetId([
            'name' => "Новость 1",
            'alias' => 'news_one',
            'text' => 'А у нас новость 1 и она очень хорошая!',
            'created_at' => date('Y-m-d H:i:s')
        ]);
        $news_2 = DB::table('news')->insertGetId([
            'name' => "Новость 2",
            'alias' => 'news_tow',
            'text' => 'А тут плохие новости(((',
            'created_at' => date('Y-m-d H:i:s')
        ]);
        $news_3 = DB::table('news')->insertGetId([
            'name' => "Новость про ПК",
            'alias' => 'news_pc',
            'text' => 'Новые компы, мощнее старых, но дороже !',
            'created_at' => date('Y-m-d H:i:s')
        ]);
        $news_4 = DB::table('news')->insertGetId([
            'name' => "Новость про Экологию",
            'alias' => 'news_eco',
            'text' => 'Нефти нет, переходим на уголь.',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        // Связи
        DB::table('category_news')->insertGetId([
            'category_id' => $section_id_1,
            'news_id' => $news_1,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('category_news')->insertGetId([
            'category_id' =>$section_id_1,
            'news_id' =>  $news_2,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('category_news')->insertGetId([
            'category_id' => $section_pc,
            'news_id' =>  $news_3,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('category_news')->insertGetId([
            'category_id' => $section_id_3,
            'news_id' => $news_4,
            'created_at' => date('Y-m-d H:i:s')
        ]);

    }
}
