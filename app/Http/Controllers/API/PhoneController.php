<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\PhoneRequest;
use App\Http\Resources\API\PhoneResource;
use App\Models\Phone;

class PhoneController extends Controller
{
    public function index()
    {
        return PhoneResource::collection(Phone::with('user')->get());
    }

    public function store(PhoneRequest $request)
    {
        $validated = $request->validated();
        try {
            $phone = Phone::create([
                'phone' => $validated['phone'],
                'user_id' => $validated['user_id'],
            ]);
            return new PhoneResource($phone);
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage());
        }
    }
}
