<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Exceptions\CustomException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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


/*	    //
        $this->renderable(function (CustomException $e, $request) {
		
 return response()->json([
                     'error' => 'Resource not found'
	                                 ], 500);	     
		//            return response()->view('errors.custom', [], 500);
//		return "err";
	});
*/
    $this->renderable(function (BadRequestHttpException $e, $request) {

        return response()->json([
                     'result' => '-1',
                     'error_code' => '400',
                     'error_message' => 'Bad Request',
                         ], 400);
    
    });

    $this->renderable(function (BadRequestHttpException $e, $request) {

        return response()->json([
                     'result' => '-1',
                     'error_code' => '401',
                     'error_message' => 'Unauthorized',
                         ], 401);
    
    });

    $this->renderable(function (AccessDeniedHttpException $e, $request) {

        return response()->json([
                     'result' => '-1',
                     'error_code' => '403',
                     'error_message' => 'Forbidden',
                         ], 403);
    
    });

    $this->renderable(function (NotFoundHttpException $e, $request) {

        return response()->json([
                     'result' => '-1',
                     'error_code' => '404',
                     'error_message' => 'Resource not found',
                         ], 404);
    
    });

    $this->renderable(function (MethodNotAllowedHttpException $e, $request) {

        return response()->json([
                     'result' => '-1',
                     'error_code' => '405',
                     'error_message' => 'Method Not Allowed',
                         ], 405);
    
    });


    $this->renderable(function (NotFoundHttpException $e, $request) {

        return response()->json([
                     'result' => '-1',
                     'error_code' => '500',
                     'error_message' => 'Request RejectedThe requested URL was rejected',
                         ], 500);
    
    });

    
    

//        parent::report($exception);
    }
    
    
}
