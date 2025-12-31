<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;
use Illuminate\Support\Str;
use App\Models\Post;
use App\Http\Resources\CommentResource;
use App\Models\User;
use App\Models\Like;
use function route;
use App\Http\Resources\TopicResource;
use App\Models\Topic;
use Illuminate\Support\Number;

class PostResource extends JsonResource
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
            'topic' => TopicResource::make($this->whenLoaded('topic')),
            'title' => $this->title,
            'body' => $this->body,
            'html' => $this->html,
            'likes_count' => Number::abbreviate($this->likes_count),
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
            'routes' => [
                'show' => $this->showRoute(),
            ],
            'can' => [
            'like' => $this->when($this->shouldIncludeLikePermission, fn () => $request->user()?->can('create', [Like::class, $this->resource])),
],
        ];
    }
}
