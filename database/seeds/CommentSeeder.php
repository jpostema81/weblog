<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\User;
use App\Message;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        // get first message of first user
        
        $message = Message::whereNull('parent_id')->first();

        // insert new comment
        $message_id = DB::table('messages')->insertGetId([
            'title' => null,
            'content' => 'Ik vond dit een erg interessant bericht.',
            'parent_id' => $message->id,
            'author_id' => $users[1]->id,
            'created_at' => Carbon::now()->subMinutes(50)->format('Y-m-d H:i:s')
        ]);

        // insert new comment
        $message_id = DB::table('messages')->insertGetId([
            'title' => null,
            'content' => 'Ik vond het een matig bericht.',
            'parent_id' => $message_id,
            'author_id' => $users[2]->id,
            'created_at' => Carbon::now()->subMinutes(40)->format('Y-m-d H:i:s')
        ]);

        // insert new comment
        DB::table('messages')->insert([
            'title' => null,
            'content' => 'Ik ben het daar niet mee eens.',
            'parent_id' => $message_id,
            'author_id' => $users[1]->id,
            'created_at' => Carbon::now()->subMinutes(20)->format('Y-m-d H:i:s')
        ]);

        // insert new comment
        DB::table('messages')->insert([
            'title' => null,
            'content' => 'Dit is geen goed bericht.',
            'parent_id' => $message->id,
            'author_id' => $users[2]->id,
            'created_at' => Carbon::now()->subDays(5)->format('Y-m-d H:i:s')
        ]);
    }
}
