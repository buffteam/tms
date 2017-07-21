<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class AvatarsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('avatars')->insert([
            [
                'u_id' => 0,
                'url' => 'uploads/avatar/default/avatar01.jpg',
                'active' => 9
            ],
            [
                'u_id' => 0,
                'url' => 'uploads/avatar/default/avatar02.png',
                'active' => 9
            ]
        ]);
    }
}
