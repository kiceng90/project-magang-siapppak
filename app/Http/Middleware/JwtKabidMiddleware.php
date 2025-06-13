<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Helpers\HelperPublic;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class JwtKabidMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::user()->id_role != config('env.role.kabid')){
            $response = HelperPublic::helpResponse(
                403, 
                [], 
                'Anda tidak memiliki akses ke halaman ini', 
                403,
                []
            );
            return response()->json($response, 403);
        }
        return $next($request);
    }
}
