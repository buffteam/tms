<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            [
               'name' => 'admin',
               'email' => 'fengdebing@oaserver.dw.gdbbk.com',
               'password' => bcrypt('1111111'),
               'auth' => 2,
            ]
        ]);
    }
}
