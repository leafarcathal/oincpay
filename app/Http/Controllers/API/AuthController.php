<?php

namespace App\Http\Controllers\API;

use \Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\ResponseController as ResponseController;
use App\Constants\UserStatusConstant;
use App\Constants\ApiKeyStatusConstant;
use App\Services\AccessCodeService;
use App\Models\ApiKey;

class AuthController extends ResponseController
{

	/**
	 * Authenticates the user based on their own base64 encoded e-mail and password. 
	 * Generates an access token valid for a short period of time. Every transaction needs an unique access token.
	 *
	 * @param Request 	$request  Data received through API call.
	 * 
	 * @throws Exception If e-mail or password are not valid.
	 * @return HTTP response
	 */ 

    public function authenticate(Request $request)
    {
    	try{

    		if(is_null($request->header('hash'))){
    			throw new Exception('API Key authorization is required for this endpoint. Format: key: hash, value: your API hash');
    		}

            $apiKey = ApiKey::where([
                'hash'      => $request->header('hash'),
                'status'    => ApiKeyStatusConstant::ACTIVE,
            ])->first();
              
            if(is_null($apiKey)){
                throw new Exception('Invalid API key value. Check your credentials and try again');
            }

            if($apiKey->owner->status == UserStatusConstant::INACTIVE){
                throw new Exception('You\'re not allowed to make API calls - Please contact OincPay support');
            }

    	} catch (Exception $e) {
		  	return $this->sendError($e->getMessage(), 401);
    	}

        try {

            $accessCode = new AccessCodeService();
            $accessCode = $accessCode->generate($apiKey->owner->id);

            if(!$accessCode){
                throw new Exception('Could not retrieve your access code. Please, try again later or contact our OincPay support.');
            }

    	   return $this->sendResponse($accessCode, 'Access code successfully generated');

        } catch (Exception $e){
            return $this->sendError($e->getMessage(), 500);
        }

    }
}
