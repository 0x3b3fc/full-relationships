<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\UserRequest;
use App\Http\Resources\API\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index(): UserResource|AnonymousResourceCollection
    {
        return UserResource::collection($this->user->with(['phone', 'roles'])->get());
    }

    public function store(UserRequest $request): UserResource
    {
        $validated = $request->validated();

        $user = $this->user->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        return new UserResource($user);
    }

    public function sync(): UserResource|JsonResponse
    {
        try {
            $user = $this->user->find(1);
            $roles = [1, 3];

            $user->roles()->sync($roles);
            $user->load(['phone', 'roles']);

            return new UserResource($user);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
