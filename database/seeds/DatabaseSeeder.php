<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);
        $this->command->info('User table seeded!');

        $this->call(CategorySeeder::class);
        $this->command->info('Category table seeded!');

        $this->call(MessageSeeder::class);
        $this->command->info('Blog posts table seeded!');

        $this->call(CommentSeeder::class);
        $this->command->info('Comments table seeded!');

        $this->call(CategoryMessageSeeder::class);
        $this->command->info('Category messages pivot table seeded!');
    }
}
