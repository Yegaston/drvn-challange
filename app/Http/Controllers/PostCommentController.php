<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostCommentRequest;
use App\Http\Requests\UpdatePostCommentRequest;
use App\Http\Resources\PostCommentResource;
use App\Http\Services\PostCommentService;
use App\Models\Blog\PostComment;
use Illuminate\Http\Request;

class PostCommentController extends BaseController
{
    private PostCommentService $postCommentService;

    public function __construct(PostCommentService $postCommentService)
    {
        $this->postCommentService = $postCommentService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->query('page', 1);
        $perPage = $request->query('per_page', 10);

        $response = $this->postCommentService->getAll($page, $perPage);
        return $this->respondWithCollection($response, PostCommentResource::class);
    }

    public function getByPostId(Request $request, int $postId)
    {
        $page = $request->query('page', 1);
        $perPage = $request->query('per_page', 10);

        $response = $this->postCommentService->getAll( $page, $perPage, $postId);
        return $this->respondWithCollection($response, PostCommentResource::class);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostCommentRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = current_user()->id;

        $response = $this->postCommentService->create($data);
        return $this->respondWithItem($response, PostCommentResource::class);
    }

    /**
     * Display the specified resource.
     */
    public function show(PostComment $postComment)
    {
        $response = $this->postCommentService->getById($postComment->id);
        return $this->respondWithItem($response, PostCommentResource::class);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostCommentRequest $request, PostComment $postComment)
    {
        $this->isOwner(current_user()->id, $postComment);

        $data = $request->validated();
        $response = $this->postCommentService->update($postComment, $data);
        return $this->respondWithItem($response, PostCommentResource::class);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PostComment $postComment)
    {
        $this->isOwner(current_user()->id, $postComment);

        $response = $this->postCommentService->delete($postComment);
        if ($response) {
            return $this->respondWithSuccess('Post comment deleted successfully');
        }
        return $this->respondWithError('Post comment not found or failed to delete');
    }
}
