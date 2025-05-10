<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostEditRequest;
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

    public function update(PostEditRequest $request, $id) {
        $validated = $request->validated();
        $post = $this->getPost($id);

        $post->title = $validated['title'];
        $post->content = $validated['content'];
        $post->save();
        return $post;
    }

    public function destroy($id) {
        $post = $this->getPost($id);
        $post->delete();
        return response()->json(['message' => 'Post deleted']);
    }

    private function getPost($id) {
        $post =  Post::find($id);
        if(!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }
    }
}
