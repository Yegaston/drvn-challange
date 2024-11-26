<?php

use App\Http\Controllers\PostController;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Blog\Post;
use App\Http\Services\PostService;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();

        Sanctum::actingAs($this->user);
    }

    public function test_create_post()
    {
        $request = new StorePostRequest([
            'title' => 'Test Post',
            'body' => 'This is a test post body.',
        ]);

        $this->assertNotNull($request);

        $service = new PostService();
        $post = $service->create($request->toArray());

        $this->assertInstanceOf(Post::class, $post);
        $this->assertEquals('Test Post', $post->title);
        $this->assertEquals('This is a test post body.', $post->body);
    }

    public function test_update_post()
    {
        $post = Post::factory()->create();

        $request = new UpdatePostRequest([
            'title' => 'Updated Title',
            'body' => 'Updated body content.',
            'slug' => $post->slug,
        ]);

        $this->assertNotNull($request);

        $service = new PostService();
        $updatedPost = $service->update($post, $request->toArray());

        $this->assertEquals('Updated Title', $updatedPost->title);
        $this->assertEquals('Updated body content.', $updatedPost->body);
    }

    public function test_delete_post()
    {
        $post = Post::factory()->create();

        $service = new PostService();
        $result = $service->delete($post);

        $this->assertTrue($result);
        $this->assertNull(Post::find($post->id));
    }


    public function test_get_single_post()
    {
        $post = Post::factory()->create();

        $service = new PostService();
        $retrievedPost = $service->getById($post->id);

        $this->assertInstanceOf(Post::class, $retrievedPost);
        $this->assertEquals($post->id, $retrievedPost->id);
        $this->assertEquals($post->title, $retrievedPost->title);
        $this->assertEquals($post->body, $retrievedPost->body);
    }

    public function test_get_all_posts()
    {
        Post::factory()->count(5)->create();

        $service = new PostService();
        $posts = $service->getAll();

        $this->assertGreaterThanOrEqual(5, count($posts->items()));
        $this->assertInstanceOf(Post::class, $posts->items()[0]);
    }
}
