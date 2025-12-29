<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Comment;
use App\Support\PostFixtures;
use App\Models\Topic;



class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call(TopicSeeder::class);
        $topics = Topic::all();

        $users = User::factory(10)->create();

        $posts = Post::factory(200)
            ->withFixture()
            ->has(Comment::factory(15)->recycle($users))
            ->recycle([$users, $topics])
            ->create();
            
            
// Create 100 comments associated with the users and posts
// Recycle prevents any additional posts from being created

        $comments = Comment::factory(100)->recycle($users)->recycle($posts)
            ->create();
        
        $patrick = User::factory()
            ->has(Post::factory(45)->recycle($topics)->withFixture())
            ->has(Comment::factory(120)->recycle($posts))
            ->create([
                'name' => 'Patrick Donahue',
                'email' => 'pdonahu1@bs5projects.com',
        ]);
    }
}
