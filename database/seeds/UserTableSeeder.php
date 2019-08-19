<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

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

        // insert new default users
        DB::table('users')->insert([
            'name' => 'Jeroen Postema',
            'email' => 'jeroen@script.nl',
            'password' => bcrypt('postema'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('users')->insert([
            'name' => 'Harry Prins',
            'email' => 'harry@script.nl',
            'password' => bcrypt('prins'),
            'created_at' => Carbon::now()->subDays(1)->format('Y-m-d H:i:s')
        ]);
    }
}
