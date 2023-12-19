<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     * @throws \Exception
     */
    public function run(): void
    {
         $users = User::factory(20)->create();

        foreach ($users as $user) {
            Post::factory(random_int(9,50))->create(['author_id' => $user->id]);
         }
    }
}
