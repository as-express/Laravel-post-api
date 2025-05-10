<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostEditRequest;
use App\Http\Requests\StorePostRequest;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Services\PostService;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function store(StorePostRequest $request)
    {
        try {
            $validated = $request->validated();
            $result = 
        } catch (ErrorException $err) {
            return $err->throw($request);
        }
    }

    public function myPosts(Request $request)
    {
        return $request->user()->posts;
    }

    public function update(PostEditRequest $request, $id)
    {
        $validated = $request->validated();
        $post = Post::find($id);
        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        $post->title = $validated['title'];
        $post->content = $validated['content'];
        $post->save();
        return $post;
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        $post->delete();
        return response()->json(['message' => 'Post deleted']);
    }
}
