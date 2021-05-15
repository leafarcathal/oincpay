<?php

namespace App\Http\Controllers\API;
use \Exception;
use App\Http\Controllers\API\ResponseController as ResponseController;
use Illuminate\Http\Request;

use App\Models\Wallet;

use App\Services\AccessCodeService;
use App\Services\WalletService;

class WalletController extends ResponseController
{
    /**
	 * Get user's current wallet data 
	 *
	 * @param Request 	    $request  Data received through API call.
	 * @param access_code   $access_code String sent through API.
	 * 
	 * @throws Exception If access token ir not valid or expired. 
	 * @return HTTP response
	 */ 

    public function get(Request $request)
    {

        // Check if all required fields are in request

        $walletService = new WalletService();

        $required = $walletService->validateRequired($request);

        if(!$required){
            return $this->sendError('The fields \'access_code\' is required', 400);
        }

        // Check if access_token is still valid

    	try{

    		if(!$request->access_code){
    			throw new Exception('Invalid access_code');
    		}

			$accessCodeService = new AccessCodeService();
    		$accessCode = $accessCodeService->check($request->access_code);

    		if(!$accessCode){
    			throw new Exception('Invalid or expired access code. Access codes are only available for ten minutes after they\'re generated.');
    		}

			$walletService = new WalletService();
			$wallet = $walletService->getByUser($accessCode->user_id);

    	   return $this->sendResponse($wallet, 'Wallet successfully retrieved!');

    	} catch (Exception $e) {
		  	return $this->sendError($e->getMessage(), 400);
    	}

    }
}
