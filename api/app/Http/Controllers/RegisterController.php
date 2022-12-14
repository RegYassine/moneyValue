<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;

class RegisterController extends Controller
{
    
    /**
     * Login
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')->plainTextToken; 
            $success['name'] =  $user->name;
   
            return $this->sendResponse($success, 'User successfully connected');
        } 
        else{ 
            return $this->sendError('Incorrect user', null);
        } 
    }

    /**
     * Logout
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $isTokenDelete = $request->user()->tokens()->delete();

        if($isTokenDelete){
            $success = [
                'success' => true,
                'data' => null,
                'message' => "User successfully disconnected"
            ];

            return $this->sendResponse($success, 'User successfully disconnected');
        } else {
            return $this->sendError('Problem with connexion', null);
        }


    }
}
