<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LawyerProfile extends Model
{
    protected  $fillable = ['user_id','name','mobile','country','state','city','zip_code','profile_pic','lawyer_type','description'];
    protected  $table = 'lawyer_profile';
}
