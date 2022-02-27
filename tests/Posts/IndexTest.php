<?php declare(strict_types=1);

namespace Tests\Posts;

use App\Models\Post;
use Tests\OpenApiTestCase;

class IndexTest extends OpenApiTestCase
{
    public function test_list_is_empty()
    {
        $this->assertCount(0, Post::where('user_id', $this->user_id)->get());

        $method = 'GET';
        $route = '/v1/posts';

        $this->json($method, $route, [], $this->headers)
            ->shouldReturnJson()
            ->seeJsonContains(['data' => []])
            ->assertResponseOk();
        $this->assertTrue($this->validator->validate($this->response->baseResponse, $route, $method));
    }
}
