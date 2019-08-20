<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Chat;
use Illuminate\Support\Facades\DB;
class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         

         $this->validate($request, [  
        'message' => 'required',
        'sender' => 'required', 
        'receiver' => 'required' 
        ]);

         $chat = new Chat;
         $chat->chat_id = $request->input('sender')."##".$request->input('receiver');
         $chat->message = $request->input('message');
         $chat->sender = $request->input('sender');
         $chat->receiver = $request->input('receiver');
         $chat->save();
         return $chat;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    $results = DB::select('SELECT DISTINCT chat_room.sender as senders, chat_room.status, users.name, users.user_type FROM chat_room
        INNER JOIN users on users.id = chat_room.sender
        WHERE chat_room.receiver = ?
        and chat_room.status = ?', [$id,0]);
    return $results;
    }

 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
