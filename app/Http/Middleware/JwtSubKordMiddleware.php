<?php

namespace App\Http\Middleware;

use App\Helpers\HelperPublic;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JwtSubKordMiddleware
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
        if(Auth::user()->id_role != config('env.role.subkord')){
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
