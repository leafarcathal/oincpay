<?php

namespace App\Http\Controllers\API;
use \Exception;
use App\Http\Controllers\API\ResponseController as ResponseController;
use Illuminate\Http\Request;

use App\Models\Wallet;
use App\Models\Transaction;

use App\Services\AccessCodeService;
use App\Services\WalletService;
use App\Services\TransactionService;


class TransactionController extends ResponseController
{
    /**
	 * Make a transaction
	 *
	 * @param Request 	    $request  Data received through API call.
	 * 
	 * @throws Exception  
	 * @return 
	 */ 

    public function make(Request $request)
    {
        // Check if all required fields are in request

        $transactionService = new TransactionService();

        $required = $transactionService->validateRequired($request);

        if(!$required){
            return $this->sendError('The fields \'access_code\', \'receiver_identifier\' and \'amount\', are required', 400);
        }

        // Check if there's an access code and if it's valid
    	try{

            if(is_null($request->access_code)){
                throw new Exception('Access code is required for any transaction.');
            }

			$accessCodeService = new AccessCodeService();
    		$accessCode = $accessCodeService->check($request->access_code);

    		if(!$accessCode){
    			throw new Exception('Invalid or expired access code. Access codes are only available for ten minutes after they\'re generated.');
    		}

    	} catch (Exception $e) {
		  	return $this->sendError($e->getMessage(), 400);
    	}

    }
}
