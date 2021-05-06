<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

class UserController extends Controller
{
    public function create(Request $request): array
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'phoneNo' => 'required|min:10|max:10',
            'bio' => 'required|min:10',
        ]);

        if ($validate->fails()) {
            return [
                'status' => 200,
                'success' => false,
                'message' => $validate->errors(),
            ];
        }

        return [
            'status' => 200,
            'success' => true,
            'message' => 'user created',
        ];
    }

    public function update(Request $request): array
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'phoneNo' => 'required|min:10|max:10',
            'bio' => 'required|min:10',
        ]);

        if ($validate->fails()) {
            return [
                'status' => 200,
                'success' => false,
                'message' => $validate->errors(),
            ];
        }

        return [
            'status' => 200,
            'success' => true,
            'message' => 'user updated',
        ];
    }

    public function delete(Request $request): array
    {

        return [
            'status' => 200,
            'success' => true,
            'message' => 'user deleted',
        ];
    }

}
