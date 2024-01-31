<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\PostRequest;
use App\Http\Resources\API\PostResource;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        return PostResource::collection(Post::with('comments')->get());
    }

    public function store(PostRequest $request)
    {
        $validated = $request->validated();
        try {
            $post = Post::create([
                'name' => $validated['name'],
            ]);
            $post->load('comments');
            return new PostResource($post);
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage());
        }
    }
}
