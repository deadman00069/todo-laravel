<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use DB;
use Validator;

class TodoController extends Controller
{
    //
    public function view(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'token' => 'required',
        ]);
        if ($validate->fails()) {
            return response([
                'success' => false,
                'message' => $validate->errors(),
            ]);
        }
        sleep(2);
        $token = $request->input('token');
        try {
            $userId = DB::table('users')->where('token', $token)->get('id');
            $success = DB::table('todos')->where('userId', '=', $userId[0]->id)->get();
            return response(
                [
                    'success' => true,
                    'data' => $success,
                ]
            );
        } catch (\Illuminate\Database\QueryException $e) {
            return $e;
        }


    }

    public function create(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'todo' => 'required',
            'token' => 'required',
        ]);
        if ($validate->fails()) {
            return response([
                'success' => false,
                'message' => $validate->errors(),
            ]);
        }
        $todo = $request->input('todo');
        $token = $request->input('token');
        try {
            $userId = DB::table('users')->where('token', $token)->get('id');

            $success = DB::table('todos')->insert([
                'userId' => $userId[0]->id,
                'todo' => $todo,
            ]);
            return response(
                [
                    'success' => $success,
                    'message' => 'todo added success',
                ]
            );
        } catch (\Illuminate\Database\QueryException $e) {
            return response(
                [
                    'success' => false,
                    'message' => $e,
                ]
            );

        }
    }

    public function complete(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'id' => 'required'
        ]);
        if ($validate->fails()) {
            return response([
                'success' => false,
                'message' => $validate->errors(),
            ]);
        }
        try {
            $id = $request->input('id');
            $success = Todo::where('id', $id)->update([
                'is_completed' => true,
            ]);
            if ($success == 1) {
                return response(
                    [
                        'success' => $success,
                        'message' => 'Task updated',
                    ]
                );
            }
            return response([
                'success' => $success,
                'message' => 'Task update fail',
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            return response([
                'success' => false,
                'message' => 'Update fail',
                'error' => $e,
            ]);
        }

    }

    public function update(Request $request): array
    {
        $validate = Validator::make($request->all(), [
            'id' => 'required',
            'todo' => 'required',
        ]);
        if ($validate->fails()) {
            return response(
                [
                    'success' => false,
                    'message' => $validate->errors(),
                ]
            );
        }
        $id = $request->input('id');
        $todo = $request->input('todo');
        try {
            $success = DB::table('todos')
                ->where('id', '=', $id)
                ->update(['todo' => $todo]);
            if ($success == 1) {
                return response(
                    [
                        'success' => $success,
                        'message' => 'Update success',
                    ]
                );
            } else {
                return response(
                    [
                        'success' => $success,
                        'message' => 'Update fails',
                    ]
                );
            }

        } catch (\Illuminate\Database\QueryException $e) {
            return response(
                [
                    'success' => false,
                    'message' => 'Update fail',
                    'error' => $e,
                ]
            );
        }
    }

    public function delete(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validate->fails()) {
            return reponse(
                [
                    'success' => false,
                    'message' => $validate->errors(),
                ]
            );
        }
        $id = $request->input('id');
        try {
            $success = DB::table('todos')
                ->where('id', $id)->delete();
            if ($success == 1) {
                return response(
                    [
                        'success' => $success,
                        'message' => 'Delete success',
                    ]
                );
            }
            return response(
                [
                    'success' => $success,
                    'message' => 'Delete fail',
                ]
            );

        } catch (\Illuminate\Database\QueryException $e) {
            return response(
                [
                    'success' => false,
                    'message' => 'Update fail',
                    'error' => $e,
                ]
            );
        }

    }
}
