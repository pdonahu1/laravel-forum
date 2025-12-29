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
        get($post->showRoute())
            ->assertComponent('Posts/Show');
});

it('passes a post to the view', function () {
    $post = Post::factory()->create();
    
    $post->load('user');

    get($post->showRoute())
        ->assertInertia(fn (Assert $page) => 
            $page->component('Posts/Show')
                 ->has('post')
                 ->where('post.id', $post->id)     
        );
});

it('passes comments to the view', function () {
    $post = Post::factory()->create();
    Comment::factory(2)->for($post)->create();
    
    // Don't manually create and load comments - just test what the controller returns
    get($post->showRoute())
        ->assertInertia(fn (Assert $page) => 
            $page->component('Posts/Show')
                 ->has('comments.data', 2)
                 ->has('comments.links')
                 ->has('comments.data.0.user')  // Verify user is present
                 ->has('comments.data.0.body')
        );
});

it('can generate a route to the show page', function () {
    $post = Post::factory()->create();

    expect($post->showRoute())->toBe(route('posts.show', [$post, Str::slug($post->title)]));
});


it('can generate additional query parameters on the show route', function () {
    $post = Post::factory()->create();

    expect($post->showRoute(['page' => 2]))
        ->toBe(route('posts.show', [$post, Str::slug($post->title), 'page' => 2]));
});


it('will redirect if the slug is incorrect', function () {
    $post = Post::factory()->create(['title' => 'Hello world']);

    get(route('posts.show', [$post, 'wrong-slug', 'page' => 2]))
        ->assertRedirect($post->showRoute(['page' => 2]));
});