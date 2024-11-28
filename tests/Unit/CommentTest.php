<?php

use App\Http\Requests\StorePostCommentRequest;
use App\Http\Requests\UpdatePostCommentRequest;
use App\Models\Blog\Post;
use App\Models\Blog\PostComment;
use App\Http\Services\PostCommentService;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CommentTest extends TestCase
{

    protected User $user;
    protected Post $post;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->post = Post::factory()->create();

        Sanctum::actingAs($this->user);
    }

    public function test_create_comment()
    {
        $request = new StorePostCommentRequest([
            'post_id' => $this->post->id,
            'text' => 'This is a test comment.',
            'created_by' => $this->user->id,
        ]);

        $this->assertNotNull($request);

        $service = new PostCommentService();
        $comment = $service->create($request->toArray());

        $this->assertInstanceOf(PostComment::class, $comment);
        $this->assertEquals('This is a test comment.', $comment->text);
        $this->assertEquals($this->post->id, $comment->post_id);
    }

    public function test_update_comment()
    {
        $comment = PostComment::factory()->create(['post_id' => $this->post->id]);

        $request = new UpdatePostCommentRequest([
            'text' => 'Updated comment text.',
        ]);

        $this->assertNotNull($request);

        $service = new PostCommentService();
        $updatedComment = $service->update($comment, $request->toArray());

        $this->assertEquals('Updated comment text.', $updatedComment->text);
    }

    public function test_delete_comment()
    {
        $comment = PostComment::factory()->create(['post_id' => $this->post->id]);

        $service = new PostCommentService();
        $result = $service->delete($comment);

        $this->assertTrue($result);
        $this->assertNull(PostComment::find($comment->id));
    }

    public function test_get_single_comment()
    {
        $comment = PostComment::factory()->create(['post_id' => $this->post->id]);

        $service = new PostCommentService();
        $retrievedComment = $service->getById($comment->id);

        $this->assertInstanceOf(PostComment::class, $retrievedComment);
        $this->assertEquals($comment->id, $retrievedComment->id);
        $this->assertEquals($comment->text, $retrievedComment->text);
    }

    public function test_get_all_comments_for_post()
    {
        PostComment::factory()->count(5)->create(['post_id' => $this->post->id]);

        $service = new PostCommentService();
        $comments = $service->getAll(1, 10, $this->post->id);

        $this->assertGreaterThanOrEqual(5, count($comments->items()));
        $this->assertInstanceOf(PostComment::class, $comments->items()[0]);
    }
}
