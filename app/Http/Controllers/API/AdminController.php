<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
class AdminController extends Controller
{
    public function dashboardDetails()
    {
    	$actClients = DB::table('users') 
                           ->select('status')
                           ->where('user_type', '=' , 'client')
                           ->where('status', '=' , 1)
                           ->count();

         $inActClients = DB::table('users') 
                           ->select('status')
                           ->where('user_type', '=' , 'client')
                           ->where('status', '=' , 0)
                           ->count();

         $actLawyers = DB::table('users') 
                           ->select('status')
                           ->where('user_type', '=' , 'lawyer')
                           ->where('status', '=' , 1)
                           ->count();
        $inActLawyers = DB::table('users') 
                           ->select('status')
                           ->where('user_type', '=' , 'lawyer')
                           ->where('status', '=' , 0)
                           ->count();
        $output = array(
        				'activateClients' => $actClients, 
        				'inActivateClients' => $inActClients,
        				'activateLawyers' => $actLawyers,
        				'inActivateLawyers' => $inActLawyers, 
        			);
         return $output;
    }


    
}
