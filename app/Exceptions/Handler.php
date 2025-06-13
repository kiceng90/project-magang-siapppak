<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

use App\Helpers\HelperPublic;
use App\Models\UserLog;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (Throwable $e, $request) {
            if ($request->expectsJson()) {
                if ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpExceptionInterface) {
                    $response = HelperPublic::helpResponse($e->getStatusCode(), null, $e->getMessage(), '', request()->all());
                    UserLog::saveLog($response);
                    return response()->json($response, $e->getStatusCode());
                } 
                
                if ($e instanceof \Illuminate\Auth\AuthenticationException) {
                    $response = HelperPublic::helpResponse(401, null, $e->getMessage(), '', request()->all());
                    UserLog::saveLog($response);
                    return response()->json($response, 401);
                }

                $response = HelperPublic::helpResponse(500, [
                    'exception' => get_class($e),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString()
                ], $e->getMessage(), '', request()->all());
                UserLog::saveLog($response);
                return response()->json($response, 500);
            }
        });
    }
}
