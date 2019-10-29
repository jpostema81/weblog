<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Category;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // get first user
        $user = \App\User::first();

        // insert new hard-coded seeder posts
        DB::table('messages')->insert([
            'title' => 'Eerste hardlooptraining',
            'content' => 'Gisteren deed ik mijn eerste looptraining na enkele weken rust. Het ging lekker.',
            'author_id' => $user->id,
            'parent_id' => null,
            'created_at' => Carbon::now()->subDays(6)->format('Y-m-d H:i:s')
        ]);

        DB::table('messages')->insert([
            'title' => 'Ligfietstraining naar Middelstum en Warffum',
            'content' => 'Gisteren fietste ik per ligger een rondje door noord Groningen',
            'author_id' => $user->id,
            'parent_id' => null,
            'created_at' => Carbon::now()->subDays(7)->format('Y-m-d H:i:s')
        ]);

        DB::table('messages')->insert([
            'title' => 'Weblog uitwerken in Laravel en Vue.js',
            'content' => 'Ik ga nu zelf de weblog opdracht in Laravel en Vue.js uitwerken.',
            'author_id' => $user->id,
            'parent_id' => null,
            'created_at' => Carbon::now()->subDays(9)->format('Y-m-d H:i:s')
        ]);

        DB::table('messages')->insert([
            'title' => 'Five Miles Out LP',
            'content' => 'Gisteren heb ik het album \'Five Miles Out\' van Mike Oldfield op mijn elektrostatische luidsprekers beluisterd. Dat klonk goed!',
            'author_id' => $user->id,
            'parent_id' => null,
            'created_at' => Carbon::now()->subDays(14)->format('Y-m-d H:i:s')
        ]);
    }
}
