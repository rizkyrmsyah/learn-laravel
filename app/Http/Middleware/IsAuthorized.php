<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\UserPermission;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class IsAuthorized
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
        $permission = Permission::where('name', Route::currentRouteName())->first();
        $userPermission = UserPermission::where('user_id', auth()->user()->id)->where('permission_id', $permission->id)->first();

        if(!$permission || !$userPermission){
            return response()->json(["message" => "Kamu tidak dapat mengakses menu ini"], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
