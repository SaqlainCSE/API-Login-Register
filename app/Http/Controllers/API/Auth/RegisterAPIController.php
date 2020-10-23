<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;

class RegisterAPIController extends Controller
{
    
    public function register(Request $request)
    {
        $loginData = $request->all();
        $validator = Validator::make($loginData, [
            'name' => ['required', 'string', 'unique:users'],
            'email' => ['required', 'string', 'email', 'unique:users'],
            'password' => ['required', 'string', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return $this->responseUnprocessable($validator->errors());
        }


        try {
            $user = $this->create($request->all());
            return $this->responseSuccess('Registered successfully.');
        }
        catch (Exception $e) {
            return $this->responseServerError('Registration error.');
        }

    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }


        // $user = new User();
        // $user->name = $request->name;
        // $user->email = $request->email;
        // $user->password = $request->password;
        // $user->save();

        // $user = User::find($user->id);

        // return response()->json([
        //     'success' => true,
        //     'message' => 'Registration Successful!',

        // ], 200);





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
