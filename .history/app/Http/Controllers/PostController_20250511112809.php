<?php

namespace App\Http\Controllers;

use App\Exceptions\ErrorException;
use App\Http\Requests\PostEditRequest;
use App\Http\Requests\StorePostRequest;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $postService;

    public function __construct(\App\Services\PostService $postService)
    {
        $this->postService = $postService;
    }

    public function store(StorePostRequest $request)
    {
        try {
            $validated = $request->validated();
            $result = $this->postService->storeService($validated);

            return response()->json(['data' => $result['data']], $result['status']);
        } catch (ErrorException $err) {
            return $err->throw($request);
        }
    }

    public function myPosts(Request $request)
    {
        try {
            $result = $this->postService->myPostsService($request);
            return response()->json(['data' => $result['data']], $result['status']);
        } catch (ErrorException $err) {
            return $err->throw($request);
        }
    }

    public function update(PostEditRequest $request, $id)
    {
        try {
            $validated = $request->validated();
            $result = $this->postService->updateService($validated, $id);

            return response()->json(['data' => $result], $result['status']);
        } catch (ErrorException $err) {
            return $err->throw($request);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $result = $this->postService->destroyService($id);
            return response()->json(['data' => $result], $result['status']);
        } catch (ErrorException $err) {
            return $err->throw($request);
        }
    }
}
