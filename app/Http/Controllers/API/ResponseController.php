<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

class ResponseController extends Controller
{

    /**
     * Return positive (200) response to API caller.
     *
     * @param  $response  Array of information;
     * @param  $message   Custom success message
     * 
     * @return \Illuminate\Http\Response
     */ 

    protected function sendResponse($result, $message)
    {
    	$response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }

     /**
     * Return error response to API caller.
     *
     * @param  $error           The error itself;
     * @param  $code            HTTP error code;
     * 
     * @return \Illuminate\Http\Response
     */ 

    protected function sendError($error, $http_code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $error,
        ];
        return response()->json($response, $http_code);
    }

}