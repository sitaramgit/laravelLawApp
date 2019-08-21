<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;
use Illuminate\Support\Facades\DB;
class UsersController extends Controller 
{
public $successStatus = 200;
/** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function login(){ 

        // return $request;
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            if($user->status == 0){
                return response()->json(['error'=>'your Account Blocked by admin'], 401); 
            }
            $success['token'] =  $user->createToken('MyApp')->accessToken; 
            $success['type'] =  $user->user_type; 
            $success['name'] =  $user->name; 
            $success['id'] =  $user->id; 
            return response()->json(['success' => $success], $this->successStatus); 
        } 
        else{ 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    }
 
/** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function register(Request $request) 
    { 

    	// return $request->all();
    	// return $_REQUEST;
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'email' => 'required|email|unique:users', 
            'password' => 'required', 
            'c_password' => 'required|same:password', 
            'user_type' => 'required',
        ]);
		if ($validator->fails()) { 
		            return response()->json(['error'=>$validator->errors()], 401);            
		        }
		$input = $request->all(); 
		        $input['password'] = bcrypt($input['password']); 
		        $user = User::create($input); 
		        $success['token'] =  $user->createToken('MyApp')->accessToken; 
		        $success['name'] =  $user->name;
		return response()->json(['success'=>$success], $this->successStatus); 
    }
/** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function details() 
    { 
        $user = Auth::user(); 
        return response()->json(['success' => $user], $this->successStatus); 
    } 


    public function logoutApi()
    { 
        $accessToken = Auth::user()->token();
        DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update([
                'revoked' => true
            ]);

        $accessToken->revoke();
        return response()->json(null, 204);
    }

    public function getAllUsers(){

        return user::all();
    }
}