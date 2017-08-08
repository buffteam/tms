<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserGroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        DB::table('user_groups')->insert([
            [
                'u_id' => 1,
                'g_id' => 1,
            ]
        ]);
    }
}
