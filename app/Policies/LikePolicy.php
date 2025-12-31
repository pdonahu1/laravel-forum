<?php

namespace App\Policies;

use App\Models\Like;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;
use App\Models\Comment;

class LikePolicy
{
    public function create(User $user, Model $likeable): bool
    {

        if (! in_array($likeable::class, [Post::class, Comment::class])) {
            return false;
        }

        return $likeable->likes()->whereBelongsTo($user)->doesntExist();
    }


    public function delete(User $user, Model $likeable): bool
    {
         if (! in_array($likeable::class, [Post::class, Comment::class])) {
            return false;
        }

        return $likeable->likes()->whereBelongsTo($user)->exists();
    }
}
