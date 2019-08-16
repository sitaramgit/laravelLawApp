<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientProfile extends Model
{
     protected  $fillable = ['user_id','name','mobile','country','state','city','zip_code','profile_pic'];
    protected  $table = 'client_profile';
}
