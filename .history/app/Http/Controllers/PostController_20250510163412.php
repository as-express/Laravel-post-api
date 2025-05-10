<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index() {
        return Post::all();
    }

    public function store(Request $request) {
        $validated = $request->validated();
        $post = Post::create({
            'title' => $validated['title'],
            'content' => $validated['content'],
            'user_id' => $validated['user_id'],
        });

        return $post;
    }
}
