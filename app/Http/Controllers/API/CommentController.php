<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\CommentRequest;
use App\Http\Resources\API\CommentResource;
use App\Models\Comment;

class CommentController extends Controller
{
    public function index()
    {
        return CommentResource::collection(Comment::with('post')->get());
    }

    public function store(CommentRequest $request)
    {
        $validated = $request->validated();
        try {
            $comment = Comment::create([
                'comment' => $validated['comment'],
                'post_id' => $validated['post_id'],
            ]);
            $comment->load('post');
            return new CommentResource($comment);
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage());
        }
    }
}
