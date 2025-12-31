<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\PostResource;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Number;
use App\Models\Like;

class CommentResource extends JsonResource
{
    private bool $shouldIncludeLikePermission = false;

    public function withLikePermission(): self 
    {
        $this->shouldIncludeLikePermission = true;
        return $this;
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => UserResource::make($this->whenLoaded('user')),
            'post' => PostResource::make($this->whenLoaded('post')),
            'body' => $this->body,
            'html' => $this->html,
            'likes_count' => Number::abbreviate($this->likes_count),
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
            'can' => [
                'update' => $request->user()?->can('update', $this->resource),
                'delete' => $request->user()?->can('delete', $this->resource),
                'like' => $this->when($this->shouldIncludeLikePermission, fn () => $request->user()?->can('create', [Like::class, $this->resource])),
        ],
        ];
    }
}
