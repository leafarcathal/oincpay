<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\AccessCodeService;


class AccessCode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        if(!$request->access_code){
            abort(response()->json(['success' => false, 'message' => 'Access code is required for this endpoint'], 403));
        }

        $accessCodeService = new AccessCodeService();
        $accessCode = $accessCodeService->check($request->access_code);

        if(!$accessCode){
            abort(response()->json(['success' => false, 'message' => 'Invalid or expired access code. Access codes are only available for ten minutes after they\'re generated'], 401));
        }

        return $next($request);
    }
}
