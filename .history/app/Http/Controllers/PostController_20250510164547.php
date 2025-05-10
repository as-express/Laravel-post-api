<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index() {
        return Post::all();
    }

    public function store(StorePostRequest $request) {
        $validated = $request->validated();
        $post = Post::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'user_id' => $request->user()->id,
        ]);

        return $post;
    }

    public function myPosts(Request $request) {
        return $request->user()->posts;
    }

    public function update(Request $request, $id) {
        $validated = $request->validated();
        $post = Post::findOrFail($id);

        $post->title = $validated['title'];
        $post->content = $validated['content'];
        $post->save();
        return $post;
    }
}
