<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Helpers\HelperPublic;

class JwtMiddleware
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
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if(!$user->is_active){
                $response = HelperPublic::helpResponse(
                    403, 
                    [], 
                    'Akun anda sudah tidak aktif, silahkan hubungi administrator untuk info selengkapnya', 
                    403,
                    []
                );

                return response()->json($response, 403);
            }
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                $response = HelperPublic::helpResponse(
                    Response::HTTP_UNAUTHORIZED, 
                    [], 
                    'Token anda salah. Silahkan login kembali.', 
                    Response::HTTP_UNAUTHORIZED,
                    []
                );
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                $response = HelperPublic::helpResponse(
                    Response::HTTP_UNAUTHORIZED, 
                    [], 
                    'Token anda kadaluarsa. Silahkan login kembali.', 
                    Response::HTTP_UNAUTHORIZED,
                    []
                );
            } else {
                $response = HelperPublic::helpResponse(
                    Response::HTTP_UNAUTHORIZED, 
                    [], 
                    'Silahkan masukkan token kedalam request.', 
                    Response::HTTP_UNAUTHORIZED,
                    []
                );
            }

            return response()->json($response, Response::HTTP_UNAUTHORIZED);
        }
        return $next($request);
    }
}
