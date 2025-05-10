<?php

namespace App\Http\Services;

use App\Exceptions\ErrorException;
use App\Models\Post;

class PostService
{
    public function storeService($data)
    {
        $post = Post::create([
            'title' => $data['title'],
            'content' => $data['content'],
            'user_id' => $data->user()->id,
        ]);

        return (object)[
            'data' => $post,
            'status' => 201,
        ];
    }

    public function myPostsService($data)
    {
        $res = $data->user()->posts;

        return (object)[
            'data' => $res,
            'status' => 200,
        ];
    }

    public function updateService($data, $id)
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

    public function destroyService($id)
    {
        $post = Post::find($id);
        if (!$post) {
            throw new ErrorException('Post not found', 404);
        }
        $post->delete();
        return (object)[
            'data' => $post,
            'status' => 200,
        ];
    }
}
