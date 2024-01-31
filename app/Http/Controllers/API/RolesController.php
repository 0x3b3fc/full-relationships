<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\RoleResource;
use App\Models\Role;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    public function index()
    {
        return RoleResource::collection(Role::with('users')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
        ]);
        try {
            $role = Role::create([
                'name' => $validated['name'],
            ]);
            return new RoleResource($role);
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage());
        }
    }

}
