<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => 'dragons'
        ];
        DB::table('tags')->insert($param);
        $param = [
            'name' => 'training'
        ];
        DB::table('tags')->insert($param);
    }
}
