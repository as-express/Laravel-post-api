<?php

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

    public function myPosts($data)
    {
        $res = $data->user()->posts;

        return (object)[
            'data' => $res,
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
        return $post;
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        if (!$post) {
            throw new ErrorException('Post not found', 404);
        }
        $post->delete();
        return response()->json(['message' => 'Post deleted']);
    }
}
