<?php

use App\Profession;
use App\User;
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
        /* $profession=DB::select('select id from professions where title = ? LIMIT 0,1', ['Desarrollador back-end']);
        $profession=Profession::
        whereTitle('Desarrollador back-end')
        ->value('id'); */
        
        $profession=Profession::
        where('title','Desarrollador back-end')
        ->value('id');
    
        User::create([
            'name'=> 'Duilio Palacios',
            'email'=> 'duilio@styde.net',
            'password'=> bcrypt('laravel'),
            'profession_id'=>$profession,
            ]);
    }
}
