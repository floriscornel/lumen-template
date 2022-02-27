<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('index', Post::class);
        $posts = Post::search($request->input('search'))
            ->where('user_id', $request->user()->id)
            ->orderBy('updated_at');
        return $posts->simplePaginate();
    }

    public function show(string $id)
    {
        $post = Post::findOrFail($id);
        $this->authorize('view', $post);
        return response()->json(new PostResource($post), 200);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Post::class);
        $data = $this->validate($request, [
            'title'   => ['required', 'string', 'min:1', 'max:255'],
            'slug'    => ['required', 'string', 'min:1', 'max:50', Rule::unique('posts')],
            'content' => ['required', 'string', 'min:1', 'max:1000'],
        ]);
        $post = new Post($data);
        $post->user()->associate($request->user());
        $post->save();
        return response()->json(new PostResource($post), 201);
    }

    public function update(Request $request, string $id)
    {
        $post = Post::findOrFail($id);
        $this->authorize('update', $post);
        $data = $this->validate($request, [
            'title'   => ['string', 'min:1', 'max:255'],
            'slug'    => ['string', 'min:1', 'max:50', Rule::unique('posts')->ignore($post->id)],
            'content' => ['string', 'min:1', 'max:1000'],
        ]);
        $post->fill($data);
        $post->save();
        return response()->json(new PostResource($post), 202);
    }

    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        $this->authorize('delete', $post);
        Post::destroy([$post->id]);
        return response('OK', 202);
    }
}
