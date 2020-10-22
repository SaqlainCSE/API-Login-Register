<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterAPIController extends Controller
{
    public function register(Request $request)
    {
        $loginData = $request->all();
        $validator = Validator::make($loginData, [
            'name' => ['required', 'string', 'unique:users'],
            'email' => ['required', 'string', 'email', 'unique:users'],
            'password' => ['required', 'string', 'confirmed'],
        ], [
            'name.required' => 'Please give your username!',
            'password.required' => 'Please give your password!',
            'email.required' => 'Please give your email!',
            'email.email' => 'Give a valid email address!',
            'email.unique' => 'Email has been used!',
            'name.unique' => 'Username has been used!',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag(),
            ]);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();

        $user = User::find($user->id);
        $accessToken = $user->createToken('authToken')->accessToken;

        return response()->json([
            'success' => true,
            'message' => 'Registration Successful!',
            'data' => ['user' => $user, 'accessToken' => $accessToken],
        ], 200);
    }


//     public function register(Request $request)
//     {
//         $request->validate([
//             'name' => 'required|string',
//             'email' => 'required|string|email|unique:users',
//             'password' => 'required|string|confirmed'
//         ]);
//         $user = new User([
//             'name' => $request->name,
//             'email' => $request->email,
//             'password' => bcrypt($request->password)
//         ]);
//         $user->save();
//         return response()->json([
//             'message' => 'Successfully created user!'
//         ], 201);
//     }



}
