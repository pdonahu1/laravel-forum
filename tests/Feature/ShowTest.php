<?php
//use Tests\TestCase;
use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use Inertia\Testing\AssertableInertia as Assert;
use App\Models\Post;
use App\Models\Comment;
use function Pest\Laravel\get;

it('can show a post', function () {
    $post = Post::factory()->create();
        get(route('posts.show', $post))
            ->assertComponent('Posts/Show');
});

it('passes a post to the view', function () {
    $post = Post::factory()->create();
    
    $post->load('user');

    get(route('posts.show', $post))
        ->assertInertia(fn (Assert $page) => 
            $page->component('Posts/Show')
                 ->has('post')
                 ->where('post.id', $post->id)     
        );
});