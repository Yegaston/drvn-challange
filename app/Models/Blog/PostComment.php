<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostComment extends Model
{
    /** @use HasFactory<\Database\Factories\Blog\PostCommentFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['post_id', 'text', 'created_by'];
}
