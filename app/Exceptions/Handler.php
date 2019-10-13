<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if($exception instanceof \Illuminate\Validation\ValidationException){
            $data = $exception->validator->getMessageBag();
            $msg = collect($data)->first();
            if(is_array($msg)){
                $msg = $msg[0];
            }

            return response()->json(['message'=>$msg],200);
        }

        if (in_array('api',$exception->guards())){
            if($exception instanceof AuthenticationException){
                return response()->json(['message'=>'token错误'],200);
            }
            if($exception instanceof ModelNotFoundException){
                return response()->json(['message'=>'该模型未找到'],200);
            }

        }

        return parent::render($request, $exception);
    }
}
