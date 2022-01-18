<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiAuthorizationController extends Controller
{
    public function registration(Request $request) : JsonResponse
    {
        $request['login'] = strtolower($request['login']);
        $validator = Validator::make($request->all(), [
            'login' => 'unique:users|required|between:5,30|regex:/^[0-9a-zA-Z-_]{5,30}$/',
            'password' => 'required|between:10,30|regex:/(?=.*[0-9])(?=.*[!@#$%^&*_])(?=.*[a-z])(?=.*[A-Z])^[0-9a-zA-Z!@#$%^&*_]{10,30}$/',
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            return response()->json(['message' => $messages], 422);
        }
        $validated = $validator->validated();

        $user = new User();
        $user->login = $validated['login'];
        $user->password = Hash::make($validated['password']);
        $user->save();

        $token = $user->createToken('token')->plainTextToken;

        $response = [
            'token' => $token,
            'user' => new UserResource($user),
        ];
        return response()->json($response, 201);
    }

    public function login(Request $request) : JsonResponse {
        $request['login'] = strtolower($request['login']);
        $validator = Validator::make($request->all(), [
            'login' => 'required|between:5,30',
            'password' => 'required|between:10,30',
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            return response()->json(['message' => $messages], 422);
        }
        $validated = $validator->validated();

        if (!Auth::attempt($validated)) {
            return response()->json(['message' => 'Invalid login or password'], 422);
        }

        $user = Auth::user();
        $token = $user->createToken('token')->plainTextToken;

        $response = [
            'token' => $token,
            'user' => new UserResource($user),
        ];
        return response()->json($response);
    }

    public function logout() : JsonResponse {
        Auth::user()->tokens()->delete();
        return response()->json(['message' => 'Logout success']);
    }
}
