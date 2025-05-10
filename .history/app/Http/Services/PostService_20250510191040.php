<?php

namespace App\Http\Services;

use App\Models\Post;
use App\Exceptions\ErrorException;

class PostService
{
    public function indexService()
    {
        $posts = Post::all();

        return (object)[
            'data' => $posts,
            'status' => 200,
        ];
    }

    public function storeService($data)
    {
        $post = Post::create([
            'title' => $data['title'],
            'content' => $data['content'],
            'user_id' => auth()->user()->id,
        ]);

        return (object)[
            'data' => $post,
            'status' => 201,
        ];
    }

    public function myPosts($request)
    {
        $posts = $request->user()->posts;

        return (object)[
            'data' => $posts,
            'status' => 200,
        ];
    }

    public function update($data, $id)
    {
        $post = Post::find($id);
        if (!$post) {
            throw new ErrorException('Post not found', 404);
        }

        $post->title = $data['title'];
        $post->content = $data['content'];
        $post->save();

        return (object)[
            'data' => $post,
            'status' => 200,
        ];
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        if (!$post) {
            throw new ErrorException('Post not found', 404);
        }

        $post->delete();
        return (object)[
            'status' => 200,
        ];
    }
}
