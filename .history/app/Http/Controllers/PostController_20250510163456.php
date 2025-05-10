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
            'user_id' => $validated['user_id'],
        ]);

        return $post;
    }
}
