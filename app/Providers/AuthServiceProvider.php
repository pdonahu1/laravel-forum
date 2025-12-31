<?php

namespace App\Providers;
use App\Models\Comment;
use App\Policies\CommentPolicy;
use App\Models\Post;
use App\Policies\PostPolicy;
use App\Models\Like;
use App\Policies\LikePolicy;
use App\Models\User;
use App\Policies\UserPolicy;


// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Comment::class => CommentPolicy::class,
        Post::class => PostPolicy::class,
        Like::class => LikePolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}