<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Users extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insertGetId([
            'name' => "aaa@aaa.aaa",
            'email' => 'aaa@aaa.aaa',
            'password' => bcrypt('aaa@aaa.aaa'),
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}
