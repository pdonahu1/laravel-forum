<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Comment;
use App\Support\PostFixtures;
use App\Models\Topic;
use App\Models\Like;



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
            ->has(Like::factory()->forEachSequence(
                ...$posts->random(100)->map(fn (Post $post) => ['likeable_id' => $post])            
                ))
            ->create([
                'name' => 'Patrick Donahue',
                'email' => 'pdonahu1@bs5projects.com',
        ]);

        // Create likes separately with unique posts
   //     $posts->random(50)->each(fn (Post $post) => Like::create([
   //         'user_id' => $patrick->id,
   //         'likeable_type' => Post::class,
   //         'likeable_id' => $post->id,
 //       ]));
    }
}
