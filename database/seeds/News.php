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
        $sections[] = DB::table('categories')->insertGetId([
            'name' => "Политика",
            'alias' => 'policy',
            'parent_id' => null,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $sections[] = DB::table('categories')->insertGetId([
            'name' => "Россия",
            'alias' => 'russia',
            'parent_id' => $sections[0],
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $sections[] = DB::table('categories')->insertGetId([
            'name' => "Сша",
            'alias' => 'usa',
            'parent_id' => $sections[0],
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $sections[] =  DB::table('categories')->insertGetId([
            'name' => "Европа",
            'alias' => 'europe',
            'parent_id' => $sections[0],
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $sections[] = DB::table('categories')->insertGetId([
            'name' => "Франция",
            'alias' => 'france',
            'parent_id' => $sections[3],
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $sections[] =  DB::table('categories')->insertGetId([
            'name' => "Германия",
            'alias' => 'germany',
            'parent_id' => $sections[3],
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $sections[] =  DB::table('categories')->insertGetId([
            'name' => "Технологии",
            'alias' => 'hitech',
            'parent_id' => null,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        $sections[] =  DB::table('categories')->insertGetId([
            'name' => "Компьютеры",
            'alias' => 'pc',
            'parent_id' => $sections[6],
            'created_at' => date('Y-m-d H:i:s')
        ]);
        $sections[] = DB::table('categories')->insertGetId([
            'name' => "Смартфоны",
            'alias' => 'mobile',
            'parent_id' => $sections[6],
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $sections[] =  DB::table('categories')->insertGetId([
            'name' => "Экология",
            'alias' => 'ecology',
            'parent_id' => null,
            'created_at' => date('Y-m-d H:i:s')
        ]);


        // Новости
        for($i = 0; $i < 10; $i++) {
            $w = $faker->word();

            $image = null;
            // https://lorempixel.com/ - bad (
            /*
            $fimage =  $faker->imageUrl(500, 150);
            $contents = file_get_contents($fimage);
            $name = substr($fimage, strrpos($fimage, '/') + 1);
            $path =  Storage::put($name, $contents);
            $image = Storage::url($path);
            */


            $news_id = DB::table('news')->insertGetId([
                'name' => $w,
                'alias' => Str::slug($w),
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
