<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Comment;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory(10)
            ->create();

// Create 200 posts associated with the users
// Recycle prevents any additional posts from being created

        $posts = Post::factory(200)->recycle($users)
            ->create();
            
// Create 100 comments associated with the users and posts
// Recycle prevents any additional posts from being created

        $comments = Comment::factory(100)->recycle($users)->recycle($posts)
            ->create();
        
        $patrick = User::factory()
            ->has(Post::factory(45))
            ->has(Comment::factory(120)->recycle($posts))
        ->create([
            'name' => 'Patrick Donahue',
            'email' => 'pdonahu1@bs5projects.com',
        ]);
    }
}
