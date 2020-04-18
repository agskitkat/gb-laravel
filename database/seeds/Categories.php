<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Categories extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                "name" => 'Политика',
                "alias" => 'policy',
                "child" => [
                    [
                        "name" => 'Россия',
                        "alias" => 'russia'
                    ],[
                        "name" => 'Сша',
                        "alias" => 'usa'
                    ],[
                        "name" => 'Европа',
                        "alias" => 'europe',
                        "child" => [
                            [
                                "name" => 'Франция',
                                "alias" => 'france'
                            ],[
                                "name" => 'Германия',
                                "alias" => 'germany'
                            ]
                        ]
                    ]
                ]
            ],[
                "name" => 'Технологии',
                "alias" => 'hitech',
                "child" => [
                    [
                        "name" => 'Компьютеры',
                        "alias" => 'pc'
                    ],[
                        "name" => 'Смартфоны',
                        "alias" => 'mobile'
                    ]
                ]
            ],[
                "name" => 'Экология',
                "alias" => 'ecology'
            ]
        ];

        foreach($categories as $section) {
            $this->seedCategory($section);
        }
    }

    protected function seedCategory($section, $parenId = false) {
        $parentId = DB::table('categories')->insertGetId([
            'name' => $section['name'],
            'alias' => $section['alias'],
            'parent_id' => $parenId?:null,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        if(isset($section['child'])) {
            foreach($section['child'] as $section) {
                $this->seedCategory($section, $parentId);
            }
        }
    }

}
