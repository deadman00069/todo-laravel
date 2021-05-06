<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Str;

class LoginSignUpController extends Controller
{
    //
    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required|min:5',
        ]);

        if ($validate->fails()) {
            return response([
                'success' => false,
                'message' => $validate->errors(),
            ], 400);
        }

        $email = $request->input('email');
        $password = $request->input('password');
        try {
            $success = DB::table('users')
                ->where('email', '=', $email)
                ->where('password', '=', $password)
                ->get();
            if ($success->isEmpty()) {
                return response([
                    'success' => false,
                    'message' => 'Login fail',
                ], 422);
            }
            return response([
                'success' => $success,
                'message' => 'Login success',
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            return response([
                'success' => false,
                'message' => $e,
            ], 400);
        }
    }

    public function signup(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'username' => 'required',
            'email' => 'required',
            'password' => 'required|min:5',
        ]);

        if ($validate->fails()) {

            return response(
                [
                    'success' => false,
                    'message' => $validate->errors(),
                ], 400
            );
        }

        $username = $request->input('username');
        $email = $request->input('email');
        $password = $request->input('password');
        $rand = Str::random(60) . Carbon::now();
        $token = hash('sha256', $rand);

        try {
            $success = DB::table('users')->insert([
                'username' => $username,
                'email' => $email,
                'password' => $password,
                'token' => $token,
            ]);
            return response(
                [
                    'success' => $success,
                    'message' => 'Sign up success',
                ],
            );
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == '1062') {
                return response(
                    [
                        'success' => false,
                        'message' => 'Duplicate email found',
                    ], 200
                );
            }
            return response(
                [
                    'success' => false,
                    'message' => $e,
                ], 400
            );
        }
    }

    public function lol()
    {
        return response([
            'message' => 'defsdsgsgsdgs',
            'loda' => 'dafssdgsdgsdgsg'
        ], 201);
    }
}
