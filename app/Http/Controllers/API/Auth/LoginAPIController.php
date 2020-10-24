<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ApiController;
use Carbon\Carbon;

class LoginAPIController extends ApiController
{
    public function createToken()
    {
        $user = User::first();
        $access_Token = $user->createToken('Token Name')->access_Token;
        return response()->json([
            'success' => true,
            'message' => 'User Details',
            'data' => $user,
            'access_Token' => $access_Token,
        ], 200);
    }

    public function login(Request $request)
    {
        $loginData = $request->all();
        $validator = Validator::make($loginData, [
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
            'remember_me' => ['required', 'boolean']
        ]);

        if ($validator->fails()) {
            return $this->responseUnprocessable($validator->errors());
        }

        if (!Auth::attempt($loginData)) {
            return $this->responseUnauthorized();
        }

        else {
            $user = User::find(Auth::user()->id);
            $access_Token = $user->createToken('authToken')->access_Token;
            return response()->json([
                'success' => true,
                'message' => 'Login Successful!',
                'data' => [
                    'user' => $user,
                    'access_Token' => $access_Token
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

