<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ApiProfileController extends Controller
{
    public function __invoke() : JsonResponse
    {
        $user = Auth::user();
        return response()->json([new UserResource($user)]);
    }
}
