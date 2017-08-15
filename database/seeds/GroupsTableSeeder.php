<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('groups')->insert([
            [
                'name' => '团队文档',
                'owner_name' => '管理员',
                'u_id' => 1,
                'type' => 1,
            ]
        ]);
    }
}
