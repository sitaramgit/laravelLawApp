<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Chat;
use Illuminate\Support\Facades\DB;
class ChatDataController extends Controller
{
    public function showChat(Request $request)
    {
        $receiver = $request->input('receiver');
        $sender = $request->input('sender');

        $recMsg = $sender."##".$receiver;
        $sentMsg = $receiver."##".$sender;

        $results = DB::select("SELECT * FROM `chat_room` WHERE `chat_id` IN ('$recMsg', '$sentMsg') ORDER BY `chat_room`.`created_at` ASC", []);
    return $results;
    }

    public function updateStatus(Request $request)
    {
        $receiver = $request->input('receiver');
        $sender = $request->input('sender');

        $recMsg = $sender."##".$receiver;
        $sentMsg = $receiver."##".$sender;

        $results = DB::select("UPDATE chat_room SET status = '1' WHERE `chat_id` IN ('$recMsg', '$sentMsg')  ", []);
    return $results;
    }
}
