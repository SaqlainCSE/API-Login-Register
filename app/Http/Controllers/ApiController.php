<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

abstract class ApiController extends Controller
{


    public function responseSuccess($message = 'Success.')
    {
        return response()->json([
            'status' => 200,
            'message' => $message,
        ], 200);
    }



    public function responseUnauthorized($errors = ['Unauthorized.'])
    {
        return response()->json([
            'status' => 401,
            'message' => 'Unauthorized',
            'errors' => $errors,
        ], 401);
    }


    public function responseServerError($errors = ['Server error.'])
    {
        return response()->json([
            'status' => 500,
            'errors' => $errors
        ], 500);
    }


    public function responseUnprocessable($errors)
    {
        return response()->json([
            'status' => 422,
            'message' => 'Invalid Input',
            'errors' => $errors,
        ], 422);
    }
}
