<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // delete all existing users first
        DB::table('users')->delete();

        // insert new default user
        DB::table('users')->insert([
            'name' => 'Jeroen Postema',
            'email' => 'jeroen@script.nl',
            'password' => bcrypt('postema'),
        ]);
    }
}
