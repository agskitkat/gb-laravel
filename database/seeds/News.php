<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class News extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('Ru_RU');

        $sections = [];

        // Категории

        /*
         * Категории надо было сеять отдельным фалом, и через массив с данными,
         * и не последовательно вызывая insert, ну что за дублирование то.
         * Нам не платят за число строк!
        */

        $sections = DB::table('categories')->get();
        // Новости
        for($i = 0; $i < 100; $i++) {
            $w = $faker->word();
            $w_2 = $faker->word();
            $w_3 = $faker->word();

            $image = null;
            // https://lorempixel.com/ - не отвечает (
            /*
            $fimage =  $faker->imageUrl(500, 150);
            $contents = file_get_contents($fimage);
            $name = substr($fimage, strrpos($fimage, '/') + 1);
            $path =  Storage::put($name, $contents);
            $image = Storage::url($path);
            */

            $news_id = DB::table('news')->insertGetId([
                'name' => $w . " ". $w_2 . " ".$w_3,
                'alias' => Str::slug($w . " ". $w_2 . " ".$w_3) . "_" . $i,
                'image' => $image,
                'text' => $faker->text(rand(200, 400)),
                'created_at' => date('Y-m-d H:i:s')
            ]);

            $Interlinked = rand(1, 4);

            // Связи
            $used_section = [];
            for($ii = 0; $ii < $Interlinked; $ii++) {

                $section = false;

                while(!$section) {
                    $cur_section = rand(0, (count($sections)-1));
                    if(in_array($cur_section, $used_section)) {
                        continue;
                    }
                    $used_section[] = $section = $cur_section;
                }

                DB::table('category_news')->insertGetId([
                    'category_id' => $section,
                    'news_id' => $news_id,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
        }

    }
}
