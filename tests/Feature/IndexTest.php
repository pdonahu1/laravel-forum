<?php

use Inertia\Testing\AssertableInertia as Assert;
use App\Http\Resources\PostResource;
use App\Models\Post;
use function Pest\Laravel\get;
use App\Models\Topic;

it('should return the correct component', function () {
    get(route('posts.index'))
        ->assertComponent('Posts/Index');
});

it('passes posts to the view', function () {
    $posts = Post::factory(3)->create();
    
    $posts->load(['user', 'topic']);

    get(route('posts.index'))
        ->assertInertia(fn (Assert $page) => 
            $page->component('Posts/Index')
                 ->has('posts.data', 3)
                 ->has('posts.links')
        );
});


it('can filter to a topic', function () {

    $general = Topic::factory(2)->create();

    $posts = Post::factory(3)->for($general)->create();

    $otherPosts =Post::factory(3)->create();

    $posts->load(['user', 'topic']);

    get(route('posts.index', ['topic' => $general]))
        ->assertInertia(fn (Assert $page) => 
            $page->component('Posts/Index')
                 ->has('posts.data', 3)
                 ->has('posts.links')
        );
});