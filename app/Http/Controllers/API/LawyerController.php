<?php

namespace App\Http\Controllers\API;

 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;   
use App\Http\Controllers\Controller;
use App\LawyerProfile;
use Validator;
use Illuminate\Support\Facades\DB;
class LawyerController extends Controller
{
    public function store(Request $request)
    {
      
       
        $this->validate($request, [ 
        'user_id' => 'required|unique:lawyer_profile',
        'name' => 'required',
        'mobile' => 'required', 
        'country' => 'required',
        'lawyer_type' => 'required',
        'state' => 'required',
        'city' => 'required', 
        'zip_code' => 'required',
        'profile_pic' => 'required',
        'description' => 'required'
        ]);

        // return $request->all();
          
        $law = new LawyerProfile;

        $law->user_id = $request->input('user_id');
        $law->name = $request->input('name');
        $law->mobile = $request->input('mobile');
        $law->country = $request->input('country');
        $law->lawyer_type = $request->input('lawyer_type');
        $law->state = $request->input('state');
        $law->city = $request->input('city');
        $law->zip_code = $request->input('zip_code');
        $law->profile_pic = $request->input('profile_pic');
        $law->description = $request->input('description');
        $law->save();
        return $law;

      
    }

    public function uploadImage(request $request)
    {    
        $ret = 'file not upload';
        if($request->hasFile('profile_pic'))
        { 
      
        $img = Storage::putfile('public/uploads',$request->file('profile_pic')); 
        $img = explode('/', $img);
        $ret = end($img);
        }
        return $ret;
    }

    public function getLawyerProfile($id)
    {     

         $profile = DB::table('lawyer_profile')
                          ->leftJoin('users', 'users.id', '=', 'lawyer_profile.user_id') 
                           ->select('lawyer_profile.*','users.email')
                           ->where('user_id', '=' , $id)
                           ->get();
        return $profile;
    }

    public function update(Request $request, $id)
    {   
         $this->validate($request, [
        'name' => 'required',
        'mobile' => 'required',
        'lawyer_type' => 'required', 
        'country' => 'required', 
        'state' => 'required',
        'city' => 'required',
        'zip_code' => 'required',
        'description' => 'required',
        'profile_pic' => 'required' 
        ]);
        

        $law = LawyerProfile::find($id); 
        $law->name = $request->input('name');
        $law->mobile = $request->input('mobile');
        $law->country = $request->input('country');
        $law->lawyer_type = $request->input('lawyer_type');
        $law->state = $request->input('state');
        $law->city = $request->input('city');
        $law->zip_code = $request->input('zip_code');
        $law->profile_pic = $request->input('profile_pic');
        $law->description = $request->input('description');
        $law->save();
        return $law;
       
         
    }

    public function getAllLawyerProfiles()
    {     

         $profile = DB::table('lawyer_profile')
                          ->join('users', 'users.id', '=', 'lawyer_profile.user_id') 
                           ->select('lawyer_profile.*','users.email','users.status') 
                           ->get();
        return $profile;
    }


    public function myClients($id)
    {
        
    $results = DB::select('SELECT DISTINCT chat_room.sender as senders, client_profile.*, users.email FROM chat_room
        INNER JOIN users on users.id = chat_room.sender 
        INNER JOIN client_profile on client_profile.user_id = users.id
        WHERE chat_room.receiver = ?', [$id]);
        return $results;
    }
}
