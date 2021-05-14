<?php

namespace App\Http\Controllers\API;

use \Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\ResponseController as ResponseController;
use App\Constants\UserStatusConstant;

class AuthController extends ResponseController
{

	/**
	 * Authenticates the user based on their own base64 encoded e-mail and password. 
	 * Generates an access token valid for a short period of time. Every transaction needs an unique access token.
	 *
	 * @param Request 	$request  Data received through API call.
	 * 
	 * @throws Exception If e-mail or password are not valid.
	 * @return AccessToken $accessToken
	 */ 

    public function authenticate(Request $request)
    {
    	try{

    		if(is_null($request->header('Authorization'))){
    			throw new Exception('Basic authorization is required for this endpoint.');
    		}

    		$userdata = $this->formatBasicAuth($request->header('Authorization'));

    		if(!$userdata){
    			throw new Exception('Invalid basic authorization. Check your "Authorization" credentials on HTTP request.');
    		}

    	} catch (Exception $e) {
		  	return $this->sendError($e->getMessage(), 404);
    	}

    	try {

    		$userdata['status'] = UserStatusConstant::ACTIVE;

    		if (!Auth::attempt($userdata)) {
	        	throw new Exception("Invalid username and password");
	        }

    	} catch (Exception $e){
		  	return $this->sendError($e->getMessage(), 400);
    	}

    	return $this->sendResponse('a','Yey');
    }

    /**
	 * Formats received basic auth string into username / password values.
	 *
	 * @param String 	$basic_auth_header	String from API request. 
	 * @return mixed 	Array of username and password with their values or boolean false on failure.
	 */ 

    private function formatBasicAuth($basic_auth_header)
    {
    	$userdata = explode('Basic ', $basic_auth_header);

    	if(!isset($userdata[1])){
    		return false;
    	}
    	
    	$userdata = base64_decode($userdata[1]);

    	if(!$userdata){
    		return false;
    	}

    	$userdata = explode(':', $userdata, 2);
    	$formattedArray = [
    		'email'		=> $userdata[0],
    		'password'	=> $userdata[1]
    	];

    	return $formattedArray;
    }
}
