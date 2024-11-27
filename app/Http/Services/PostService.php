<?php

namespace App\Http\Services;

use App\Models\Blog\Post;
use Illuminate\Support\Str;

class PostService
{
    public function create(array $data): Post
    {
        $data['created_by'] = current_user()->id;
        $data['slug'] = Str::slug($data['title']);

        // Check if the slug is already taken and hadle it
        if (Post::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $data['slug'] . '-' . Str::random(5);
        }

        // Sanitize the body to prevent XSS attacks
        $data['body'] = strip_tags($data['body']);

        return Post::create($data);
    }

    public function getAll(int $page = 1, int $perPage = 10)
    {
        return Post::with('comments')->with('createdBy')->paginate($perPage, ['*'], 'page', $page);
    }

    public function getById(int $id): Post
    {
        return Post::find($id);
    }

    public function update(Post $post, array $data): Post
    {
        $post->update($data);
        return $post;
    }

    public function delete(Post $post): bool
    {
        return $post->delete();
    }
}
