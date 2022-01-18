<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __invoke()
    {
        $user = Auth::user();
        return view('profile', ['user' => new UserResource($user)]);
    }
}
