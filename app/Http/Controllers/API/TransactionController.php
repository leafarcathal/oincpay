<?php

namespace App\Http\Controllers\API;
use \Exception;
use App\Http\Controllers\API\ResponseController as ResponseController;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Transaction;

use App\Services\AccessCodeService;
use App\Services\WalletService;
use App\Services\TransactionService;
use App\Services\UserService;

use App\Jobs\SendMailJob;
use App\Jobs\SendSmsJob;


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

            if(!$walletService->checkFunds($accessCode->owner->id, $request->amount)){
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

            $senderUser = User::where('id', $accessCode->owner->id)->first();
            $receiverUser = User::where('id', $receiverUser->id)->first();

            $transaction = $transactionService->create($accessCode, $senderUser, $receiverUser, $request->amount);
            
            if(!$transaction){
                throw new Exception('Unable to create  your transaction. Please try again later or contact Oincpay support.');
            }
        } catch (Exception $e){
            return $this->sendError($e->getMessage(), 500);

        }

        // Attempt to transfer amount between wallets

        try {

            $transaction = $walletService->transfer($transaction);

            if(!$transaction){
                throw new Exception('Unable to proccess your transaction. Please try again later or contact Oincpay support.');
            }

        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), 500);
        }

        // Notify the receiver, but does not wait for an answer. This runs asynchronously using laravel queue system.

        SendMailJob::dispatch();
        SendSmsJob::dispatch();

       return $this->sendResponse(['transaction' => 
        [
            'uuid'      => $transaction->uuid,
            'status'    => $transaction->status,
            'date'      => $transaction->created_at,
            'amount'    => $transaction->amount 
        ]], 'Your transaction was successful!');
    }
}
