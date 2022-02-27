<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Http\Validators\PostValidator;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('index', Post::class);

        $posts = Post::search($request->input('q'))->where('user_id', $request->user()->id)
            ->orderBy('updated_at');

        // return $posts->simplePaginate();

        // $result = $posts->simplePaginateRaw()->raw();
        // $result['data'] = array_map(function ($t) {
        //     return new PostResource(new Post($t));
        // }, $result['data']['hits']);

        $result = $posts->raw();

        return $result;
    }

    public function store(Request $request)
    {
        $this->authorize('create', Post::class);
        $data = (new PostValidator())->validate(
            $request->all(),
            $post = new Post()
        );
        $post->fill($data);
        $post->save();
        return new PostResource($post);
    }

    public function show(string $id)
    {
        $post = Post::findOrFail($id);
        $this->authorize('view', $post);
        return new PostResource($post);
    }

    public function update(Request $request, string $id)
    {
        $post = Post::findOrFail($id);
        $this->authorize('update', $post);
        $data = (new PostValidator())->validate(
            $request->all(),
            $post
        );
        $post->fill($data);
        $post->save();
        return new PostResource($post);
    }

    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        $this->authorize('delete', $post);
        return Post::destroy([$post->id]);
    }
}
