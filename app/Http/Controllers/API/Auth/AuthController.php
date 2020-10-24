<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function auth_user()
    {
        $user = User::find(Auth::user()->id);

        if (!Auth::attempt($user)) {
            return $this->responseUnauthorized();
        }
        return response()->json([
            'success' => true,
            'message' => 'Authenticated user',
            'data' => $user,
        ], 200);
    }
}
