<?php

namespace App\Models\Blog;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostComment extends Model
{
    /** @use HasFactory<\Database\Factories\Blog\PostCommentFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['post_id', 'text', 'created_by'];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
