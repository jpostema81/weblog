<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BlogPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // delete all existing posts first
        DB::table('blog_posts')->delete();

        // get first user
        $user = \App\User::first();

        // insert new posts
        DB::table('blog_posts')->insert([
            'title' => 'Eerste hardlooptraining',
            'content' => 'Gisteren deed ik mijn eerste looptraining na enkele weken rust. Het ging lekker.',
            'author_id' => $user->id,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('blog_posts')->insert([
            'title' => 'Ligfietstraining naar Middelstum en Warffum',
            'content' => 'Gisteren fietste ik per ligger een rondje door noord Groningen',
            'author_id' => $user->id,
            'created_at' => Carbon::now()->subDays(1)->format('Y-m-d H:i:s')
        ]);

        DB::table('blog_posts')->insert([
            'title' => 'Weblog uitwerken in Laravel en Vue.js',
            'content' => 'Ik ga nu zelf de weblog opdracht in Laravel en Vue.js uitwerken.',
            'author_id' => $user->id,
            'created_at' => Carbon::now()->subDays(7)->format('Y-m-d H:i:s')
        ]);

        DB::table('blog_posts')->insert([
            'title' => 'Five Miles Out LP',
            'content' => 'Gisteren heb ik het album \'Five Miles Out\' van Mike Oldfield op mijn elektrostatische luidsprekers beluisterd. Dat klonk goed!',
            'author_id' => $user->id,
            'created_at' => Carbon::now()->subDays(21)->format('Y-m-d H:i:s')
        ]);
    }
}
