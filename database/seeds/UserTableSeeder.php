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
<<<<<<< HEAD
            'password' => Hash::make('postema'),
            'api_token' => Str::random(60),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
=======
            'password' => Hash::make('postemapostema'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'api_token' => Str::random(60),
>>>>>>> 131f2384f4ea71ac7b8002cf602b0e70249a787a
        ]);

        DB::table('users')->insert([
            'name' => 'Harry Prins',
            'email' => 'harry@script.nl',
<<<<<<< HEAD
            'password' => Hash::make('prins'),
            'api_token' => Str::random(60),
            'created_at' => Carbon::now()->subDays(1)->format('Y-m-d H:i:s')
=======
            'password' => Hash::make('prinsprins'),
            'created_at' => Carbon::now()->subDays(1)->format('Y-m-d H:i:s'),
            'api_token' => Str::random(60),
>>>>>>> 131f2384f4ea71ac7b8002cf602b0e70249a787a
        ]);

        DB::table('users')->insert([
            'name' => 'Marieke Post',
            'email' => 'marieke@script.nl',
<<<<<<< HEAD
            'password' => Hash::make('post'),
            'api_token' => Str::random(60),
            'created_at' => Carbon::now()->subDays(2)->format('Y-m-d H:i:s')
=======
            'password' => Hash::make('postpost'),
            'created_at' => Carbon::now()->subDays(2)->format('Y-m-d H:i:s'),
            'api_token' => Str::random(60),
>>>>>>> 131f2384f4ea71ac7b8002cf602b0e70249a787a
        ]);
    }
}
