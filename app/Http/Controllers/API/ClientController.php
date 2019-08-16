<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ClientProfile;
use Illuminate\Support\Facades\DB;
class ClientController extends Controller
{
     public function store(Request $request)
    {
      
       
        $this->validate($request, [ 
        'user_id' => 'required|unique:client_profile',
        'name' => 'required',
        'mobile' => 'required', 
        'country' => 'required', 
        'state' => 'required',
        'city' => 'required', 
        'zip_code' => 'required',
        'profile_pic' => 'required' 
        ]);

        // return $request->all();
          
        $client = new ClientProfile;

        $client->user_id = $request->input('user_id');
        $client->name = $request->input('name');
        $client->mobile = $request->input('mobile');
        $client->country = $request->input('country'); 
        $client->state = $request->input('state');
        $client->city = $request->input('city');
        $client->zip_code = $request->input('zip_code');
        $client->profile_pic = $request->input('profile_pic'); 
        $client->save();
        return $client;

      
    }


    public function getClientProfile($id)
    {     

         $profile = DB::table('client_profile')
                          ->leftJoin('users', 'users.id', '=', 'client_profile.user_id') 
                           ->select('client_profile.*','users.email')
                           ->where('user_id', '=' , $id)
                           ->get();
        return $profile;
    }


     public function update(Request $request, $id)
    {   
         $this->validate($request, [
        'name' => 'required',
        'mobile' => 'required', 
        'country' => 'required', 
        'state' => 'required',
        'city' => 'required',
        'zip_code' => 'required', 
        'profile_pic' => 'required' 
        ]);
        

        $client = ClientProfile::find($id); 
        $client->name = $request->input('name');
        $client->mobile = $request->input('mobile');
        $client->country = $request->input('country'); 
        $client->state = $request->input('state');
        $client->city = $request->input('city');
        $client->zip_code = $request->input('zip_code');
        $client->profile_pic = $request->input('profile_pic'); 
        $client->save();
        return $client;
       
        // return redirect('/task')->with('responce', ' Task Updated successfully');
    }


    public function getAllClients()
    {     

         $profile = DB::table('client_profile')
                          ->join('users', 'users.id', '=', 'client_profile.user_id') 
                           ->select('client_profile.*','users.email','users.status')
                           ->get();
        return $profile;
    }


    public function updateStatus(Request $request)
    { 
        $this->validate($request, [ 
        'user_id' => 'required',
        'status' => 'required' 
        ]);

       $upd = DB::table('users')
        ->where('id', $request->input('user_id'))           
        ->update(array('status' => $request->input('status')));  
        return $upd; 
    }
    

    public function getClientDashboard($id)
    {     

        $client = DB::table('client_profile')
                          ->leftJoin('users', 'users.id', '=', 'client_profile.user_id') 
                           ->select('client_profile.*')
                           ->where('user_id', '=' , $id)
                           ->get(); 
        $client = $client[0];
        
         $nearLaw = DB::table('lawyer_profile') 
                          ->join('users', 'users.id', '=', 'lawyer_profile.user_id') 
                          ->select('lawyer_profile.*','users.email')
                           ->where('lawyer_profile.zip_code', '=' , $client->zip_code)
                           ->where('users.status', '=' , 1)
                           ->get();

         $areaLawyers = DB::table('lawyer_profile') 
                          ->join('users', 'users.id', '=', 'lawyer_profile.user_id') 
                          ->select('lawyer_profile.*','users.email')
                           ->where('lawyer_profile.zip_code', '!=' , $client->zip_code)
                           ->where('lawyer_profile.country', '=' , $client->country)
                           ->where('lawyer_profile.state', '=' , $client->state)
                           ->where('lawyer_profile.city', '=' , $client->city)
                           ->where('users.status', '=' , 1)
                           ->get();
        return  array('nearLawyers' => $nearLaw, 'areaLawyers' => $areaLawyers );
    }

    
}
