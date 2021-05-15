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
use App\Services\UserService;


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

        // New services instances
        $transactionService = new TransactionService();
        $walletService = new WalletService();
        $userService = new UserService();

        // Check if all required fields are in request
        $required = $transactionService->validateRequired($request);

        if(!$required){
            return $this->sendError('The fields \'access_code\', \'receiver_identifier\' and \'amount\' are required', 400);
        }

        // Check if there's an access code and if it's still valid
    	try{

            if(is_null($request->access_code)){
                throw new Exception('Access code is required for any transaction.');
            }

			$accessCodeService = new AccessCodeService();
    		$accessCode = $accessCodeService->check($request->access_code);

    		if(!$accessCode){
    			throw new Exception('Invalid or expired access code. Access codes are only available for ten minutes after they\'re generated.');
    		}

            unset($accessCodeService);

    	} catch (Exception $e) {
		  	return $this->sendError($e->getMessage(), 400);
    	}

        // Check if user's wallet has the amount they're trying to transfer

        try{

            if(!$walletService->checkFunds($accessCode->user_id, $request->amount)){
                throw new Exception('You don\'t have enough funds for this transaction. You can check your wallet through the POST/wallet endpoint');
            }

        } catch (Exception $e){
            return $this->sendError($e->getMessage(), 403);
        }

        // Check if receiver user exists based on document or e-mail. Also checks if the user sending and receiving funds are the same.  

        try {

            $receiverUser = $userService->getByEmailOrDocument($request->receiver_identifier);

            if(!$receiverUser){
                throw new Exception('Invalid user identifier. Please check your receiver_identifier information and try again');
            }

            if($receiverUser->id == $accessCode->user_id){
                throw new Exception('Invalid user identifier. You can\'t send funds to your own wallet');
            }

        } catch (Exception $e){
            return $this->sendError($e->getMessage(), 403);
        }

        // Create the transaction

        try {

            $senderWallet = Wallet::where('user_id', $accessCode->user_id)->first();
            $receiverWallet = Wallet::where('user_id', $receiverUser->id)->first();

            $transaction = $transactionService->create($accessCode, $senderWallet, $receiverWallet, $request->amount);

        } catch (Exception $e){

        }

    }
}
