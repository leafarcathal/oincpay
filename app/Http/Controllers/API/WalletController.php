<?php

namespace App\Http\Controllers\API;
use \Exception;
use App\Http\Controllers\API\ResponseController as ResponseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Wallet;
use App\Models\AccessCode;

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

        // Check required fields 
        try{

            $validator = Validator::make($request->all(), [
                'access_code'           => 'required|string|min:1|max:80',
            ]);

            if($validator->fails()){
                throw new Exception('Access code is required for this endpoint');
            }
        } catch (Exception $e){
            return $this->sendError($e->getMessage(), 403);
        }

    	try{

            $accessCode = AccessCode::where('access_code', $request->access_code)->first();

			$walletService = new WalletService();
			$wallet = $walletService->getByUser($accessCode->user_id);

            if(!$wallet){
                throw new Exception('Could not retrieve your wallet information. Please try again later');
            }

    	   return $this->sendResponse($wallet, 'Wallet successfully retrieved!');

    	} catch (Exception $e) {
		  	return $this->sendError($e->getMessage(), 500);
    	}

    }
}
