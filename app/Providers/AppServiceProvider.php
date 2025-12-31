<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Database\Eloquent\Model;
use App\Models\Topic;
use App\Models\Post;
use App\Models\User;
use App\Support\PostFixtures;
use Illuminate\Database\Eloquent\Relations\Relation;
use App\Models\Comment;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();

        Model::preventLazyLoading();
        Model::unguard();
        Relation::enforceMorphMap([
            'comment' => Comment::class,
            'post' => Post::class,
            'user' => User::class,
        ]);
    }
}
