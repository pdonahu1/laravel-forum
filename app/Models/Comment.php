<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\Post;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Comment extends Model
{
    /** @use HasFactory<\Database\Factories\CommentFactory> */
    use HasFactory;
    use \App\Models\Concerns\ConvertMarkdownToHtml;

    protected $fillable = ['user_id', 'post_id', 'body', 'html'];
    protected $withCount = ['likes'];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }    

    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }
}
