<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\UserRequest;
use App\Http\Resources\API\UserResource;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        return UserResource::collection(User::with(['phone', 'roles'])->get());
    }

    public function store(UserRequest $request)
    {
        $validated = $request->validated();
        try {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
            ]);
            return new UserResource($user);
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage());
        }
    }

    public function sync()
    {
        $user = User::find(1);
        $roles = [1, 3];
        try {
            $user->roles()->sync($roles);
            $user->load(['phone', 'roles']);
            return new UserResource($user);
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage());
        }
    }
}
