<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class LoginAPIController extends Controller
{
    public function createToken()
    {
        $user = User::first();
        $accessToken = $user->createToken('Token Name')->accessToken;
        return response()->json([
            'success' => true,
            'message' => 'User Details',
            'data' => $user,
            'accessToken' => $accessToken,
        ], 200);
    }

    public function login(Request $request)
    {
        $loginData = $request->all();
        $validator = Validator::make($loginData, [
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Please give your email!',
            'password.required' => 'Please give your password!',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag(),
            ]);
        }

        if (!Auth::attempt($loginData)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid login!',
                'data' => $loginData,
            ], 404);
        } else {
            $user = User::find(Auth::user()->id);
            $accessToken = $user->createToken('authToken')->accessToken;
            return response()->json([
                'success' => true,
                'message' => 'Login Successful!',
                'data' => [
                    'user' => $user,
                    'accessToken' => $accessToken
                ],
            ], 200);
        }

    }

    }






    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|string|email',
    //         'password' => 'required|string',
    //         'remember_me' => 'boolean'
    //     ]);
    //     $credentials = request(['email', 'password']);
    //     if(!Auth::attempt($credentials))
    //         return response()->json([
    //             'message' => 'Unauthorized'
    //         ], 401);
    //     $user = $request->user();
    //     $tokenResult = $user->createToken('Personal Access Token');
    //     $token = $tokenResult->token;
    //     if ($request->remember_me)
    //         $token->expires_at = Carbon::now()->addWeeks(1);
    //     $token->save();
    //     return response()->json([
    //         'access_token' => $tokenResult->accessToken,
    //         'token_type' => 'Bearer',
    //         'expires_at' => Carbon::parse(
    //             $tokenResult->token->expires_at
    //         )->toDateTimeString()
    //     ]);
    // }

