<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Http\Services\PostService;
use App\Models\Blog\Post;
use Illuminate\Http\Request;

class PostController extends BaseController
{
    private PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->query('page', 1);
        $perPage = $request->query('per_page', 10);
        $response = $this->postService->getAll($page, $perPage);
        return $this->respondWithCollection($response, PostResource::class);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        return $this->respondWithItem($this->postService->create($request->all()), PostResource::class);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return $this->respondWithItem($post, PostResource::class);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $res = $this->postService->update($post, $request->validated());
        return $this->respondWithItem($res, PostResource::class);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if ($this->postService->delete($post)) {
            return $this->respondWithSuccess('Post deleted successfully');
        }
        return $this->respondWithError('Post not found or failed to delete');
    }
}
