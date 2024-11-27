<?php

namespace App\Http\Services;

use App\Models\Blog\PostComment;

class PostCommentService
{
    public function getAll(int $page, int $perPage, int $postId = null)
    {
        $query = PostComment::query();

        if ($postId) {
            $query->where('post_id', $postId);
        }

        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    public function getById(int $id)
    {
        return PostComment::findOrFail($id);
    }

    public function create(array $data)
    {
        return PostComment::create($data);
    }


    public function update(PostComment $postComment, array $data)
    {
        $postComment->update($data);
        return $postComment;
    }

    public function delete(PostComment $postComment)
    {
        return $postComment->delete();
    }
}
