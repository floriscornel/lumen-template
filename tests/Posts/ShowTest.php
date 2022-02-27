<?php declare(strict_types=1);

namespace Tests\Posts;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;
use Tests\OpenApiTestCase;

class ShowTest extends OpenApiTestCase
{
    public function test_post_200()
    {
        $post = Post::factory(1, ['user_id' => $this->user_id])->create()[0];
        $method = 'GET';
        $route = "/v1/posts/$post->id";

        $this->assertCount(1, Post::where('user_id', $this->user_id)->get());

        $this->json($method, $route, [], $this->headers)
            ->shouldReturnJson()
            ->assertResponseOk();
        $this->assertTrue($this->validator->validate($this->response->baseResponse, $route, $method));
    }

    public function test_post_401()
    {
        $post = Post::factory(1, ['user_id' => $this->user_id])->create()[0];
        $method = 'GET';
        $route = "/v1/posts/$post->id";

        $this->json($method, $route, [], ['Accept' => 'application/json'])
            ->assertResponseStatus(401);
        $this->assertTrue($this->validator->validate($this->response->baseResponse, $route, $method));
    }

    public function test_post_403()
    {
        $otherUser = User::factory()->create();
        $postBelongingToOtherUser = Post::factory(1, ['user_id' => $otherUser->id])->create()[0];

        $method = 'GET';
        $route = "/v1/posts/$postBelongingToOtherUser->id";

        $this->json($method, $route, [], $this->headers)
            ->assertResponseStatus(403);
        $this->assertTrue($this->validator->validate($this->response->baseResponse, $route, $method));
    }

    public function test_post_404_not_existing()
    {
        $nonExistingPostID = Str::uuid()->toString();

        $method = 'GET';
        $route = "/v1/posts/$nonExistingPostID";

        $this->json($method, $route, [], $this->headers)
            ->assertResponseStatus(404);
        $this->assertTrue($this->validator->validate($this->response->baseResponse, $route, $method));
    }

    public function test_post_404_deleted()
    {
        $post = Post::factory(1, ['user_id' => $this->user_id])->create()[0];

        $method = 'GET';
        $route = "/v1/posts/$post->id";

        $post->delete();

        $this->json($method, $route, [], $this->headers)
            ->assertResponseStatus(404);
        $this->assertTrue($this->validator->validate($this->response->baseResponse, $route, $method));
    }
}
