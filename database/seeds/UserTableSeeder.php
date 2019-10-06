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
            'first_name' => 'Jeroen',
            'last_name' => 'Postema',
            'email' => 'jeroen@script.nl',
            'password' => Hash::make('postemapostema'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('users')->insert([
            'first_name' => 'Harry',
            'last_name' => 'Prins',
            'email' => 'harry@script.nl',
            'password' => Hash::make('prinsprins'),
            'created_at' => Carbon::now()->subDays(1)->format('Y-m-d H:i:s'),
        ]);

        DB::table('users')->insert([
            'first_name' => 'Marieke',
            'last_name' => 'Post',
            'email' => 'marieke@script.nl',
            'password' => Hash::make('postpost'),
            'created_at' => Carbon::now()->subDays(2)->format('Y-m-d H:i:s'),
        ]);

        // let the MessageFactory which uses the BlogArticleFaker custom Provider create a large amount of auto-generated blog messages
        // and link it to the a blog user
        foreach(App\User::all() as $blogUser)
        {
            $blogUser->messages()->createMany(
                factory(App\Message::class, 50)->make()->toArray()
            );
        }
    }
}
