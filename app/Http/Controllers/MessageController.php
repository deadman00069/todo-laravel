<?php

namespace App\Http\Controllers;

use App\Models\ChatRoom;
use Illuminate\Http\Request;
use DB;
use App\Events\NewMessage;

class MessageController extends Controller
{
    public function sendMessage(Request $request)
    {
        $userId = $request->input('userId');
        $roomId = $request->input('roomId');
        $message = $request->input('message');

        event(new NewMessage($userId, $message, $roomId));
        return [
            'success' => true,
            'message' => 'event success',
        ];
    }

    public function getMessage(Request $request)
    {
        $roomId = $request->input('roomId');
        return response([
            'success' => true,
            'data' => DB::table('messages')->where('room_id', $roomId)->get(),
        ]);
    }

    public function getChatRoom()
    {
        return response([
                'success' => true,
                'message' => 'chat room fetch success',
                'data' => ChatRoom::all(),
            ]
        );
    }

    public function yo()
    {

        return DB::table('messages')->join('users', 'messages.userId', '=', 'users.id')->get();
    }

}
