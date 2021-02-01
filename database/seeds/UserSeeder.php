<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$profession=DB::select('select id from professions where title = ? LIMIT 0,1', ['Desarrollador back-end']);
        $profession=DB::table('professions')
        ->whereTitle('Desarrollador back-end')
        ->value('id');
    
        DB::table('users')->insert([
            'name'=> 'Duilio Palacios',
            'email'=> 'duilio@styde.net',
            'password'=> bcrypt('laravel'),
            'profession_id'=>$profession,
            ]);
    }
}
