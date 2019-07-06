<?php

namespace App\Exceptions;

use Exception;
use App\Common\ApiErrDesc;
use app\Libs\ResponseJson;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;

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
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
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
        // 如果路由中含有 "admin" 
        if($request->is('admin/*')){
            if($exception instanceof ValidationException){
                $result = [
                    "code"=>422,
                    "msg"=>implode('|',array_collapse($exception->errors()))
                ];
                return response()->json($result);
            }
        }

        // 如果路由中含有 "api"
        if($request->is('api/*')){
            if($exception instanceof ApiException){
                $code = $exception->getCode();
                $msg  = $exception->getMessage();
            }else{
                $code = $exception->getCode();
                if(!$code || $code < 0){
                    $code = ApiErrDesc::NOT_KNOW_ERR[0];
                }
                $msg = $exception->getMessage() ?: ApiErrDesc::NOT_KNOW_ERR[1];
            }
            echo ResponseJson::JsonData($code,$msg);
        }
        return parent::render($request, $exception);
    }
}
