<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\RoleResource;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RolesController extends Controller
{
    private $role;

    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    public function index(): RoleResource|AnonymousResourceCollection
    {
        return RoleResource::collection($this->role->with('users')->get());
    }

    public function store(Request $request): RoleResource|JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required',
            ]);

            $role = $this->role->create([
                'name' => $validated['name'],
            ]);

            return new RoleResource($role);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
