<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;

class ForgotPasswordContoller extends ApiController
{
    public function forgot(Request $request)
    {
        $validator = Validator::make($request->only('email'),[
            'email' => ['required', 'string', 'email'],
            'exists' => ["We couldn't find an account with that email."]
        ]);

        if ($validator->fails()) {
            return $this->responseUnprocessable($validator->errors());
        }

        $response= Password::sendResetLink($validator);

        if ($response) {
            return $this->responseSuccess('Reset password link sent on your email id.');
        }
        else {
            return $this->responseServerError();
        }
    }



    public function reset(Request $request)
    {

        if ($request->id) {
            // If request contains an id, we'll use that to fetch email.
            $user = User::where('id', $request->id)->first();
            if ($user) {
                $request->request->add(['email' => $user->email]);
            }
        }

        $validator = Validator::make([

            'email' => ['required', 'string', 'email'],
            'token' => ['required', 'string'],
            'password' => ['required', 'string', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return $this->responseUnprocessable($validator->errors());
        }

        $reset_password_status = Password::reset($validator, function ($user, $password) {
            $user->password = $password;
            $user->save();
        });

        if ($reset_password_status == Password::INVALID_TOKEN) {
            return $this->responseServerError('Password reset failed.');
        }

        return $this->responseSuccess('Password reset successful.');
    }
}
