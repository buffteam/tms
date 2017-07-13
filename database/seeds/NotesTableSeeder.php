<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class NotesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $mdNotes = file_get_contents(base_path().'/README.md');
        //
        DB::table('notes')->insert([
            [
                'title' => 'README',
                'origin_content' => $mdNotes,
                'u_id' => 2,
                'f_id' => 1,
            ],
            [
                'title' => '欢迎使用',
                'content' => '欢迎使用',
                'u_id' => 2,
                'f_id' => 1,
            ]

        ]);
    }
}
