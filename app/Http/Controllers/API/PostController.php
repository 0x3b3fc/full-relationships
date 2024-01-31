<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\PostRequest;
use App\Http\Resources\API\PostResource;
use App\Models\Post;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PostController extends Controller
{
    private $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function index(): PostResource|AnonymousResourceCollection
    {
        return PostResource::collection($this->post->with('comments')->get());
    }

    public function store(PostRequest $request): PostResource|JsonResponse
    {
        try {
            $validated = $request->validated();

            $post = $this->post->create([
                'name' => $validated['name'],
            ]);

            $post->load('comments');

            return new PostResource($post);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
