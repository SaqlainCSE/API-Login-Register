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
        return response()->json([
            'success' => true,
            'message' => 'authenticated user details fetched',
            'data' => $user,
        ], 200);
    }
}
