<?php

use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // delete all existing comments first
        DB::table('comments')->delete();

        // get firs blogpost of first user
        $user = \App\User::first();
        $blogpost = $user->blogPosts()->first();


    }
}
