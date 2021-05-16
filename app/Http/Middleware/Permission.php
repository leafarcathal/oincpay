<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\UserGroups;
use App\Services\PermissionService;

class Permission
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
        // Get permissions by Access Code
        $permissionService = new PermissionService();
        $permissions = $permissionService->getByAccessCode($request->access_code);

        if(!$permissions){
            abort(response()->json(['success' => false, 'message' => 'Your user does not have privileges to access this endpoint'], 401));
        }

        // Retrieve current controller and method information
        $route = $this->getControllerAndMethod();

        // Prepare controllers and methods for comparison
        $controllers = [];
        $methods = [];
        foreach($permissions as $key => $value){
            $controllers[]  = $value->controller;
            $methods[]      = $value->method;
        }

        // Check if user has the rights to access this method
        if(in_array($route['controller'], $controllers) && in_array($route['method'], $methods)){
            return $next($request);
        } else {
            abort(response()->json(['success' => false, 'message' => 'Your user does not have privileges to access this endpoint'], 401));
        }
    }

    /**
     * Return current controller and method to be used on permission check.
     *
     * @return array with controller and method;
     */

    private function getControllerAndMethod()
    {
        $currentAction = \Route::currentRouteAction();
        list($controller, $method) = explode('@', $currentAction);
        $controller = preg_replace('/.*\\\/', '', $controller);
        $controller = str_replace('Controller', '', $controller);
        return ['controller' => strtolower($controller), 'method' => strtolower($method)];
    }
}
