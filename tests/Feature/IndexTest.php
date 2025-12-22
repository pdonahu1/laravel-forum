<?php

use Inertia\Testing\AssertableInertia as Assert;
use App\Http\Resources\PostResource;
use App\Models\Post;
use function Pest\Laravel\get;

it('should return the correct component', function () {
    get(route('posts.index'))
        ->assertComponent('Posts/Index');
});

it('passes posts to the view', function () {
    Post::factory(3)->create();
    
    get(route('posts.index'))
        ->assertInertia(fn (Assert $page) => 
            $page->component('Posts/Index')
                 ->has('posts.data', 3)
                 ->has('posts.links')
        );
});