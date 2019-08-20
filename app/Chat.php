<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected  $fillable = ['chat_id','message','sender','receiver'];
    protected  $table = 'chat_room';
}
