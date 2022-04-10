<?php

namespace App\Exceptions;

use App\Kernel\DatabaseFilter\Exceptions\NotFoundModelForFilter;
use App\Kernel\Response\Traits\ResponseMessageTrait;
use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    use ResponseMessageTrait;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        NotFoundModelForFilter::class
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
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
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $this->error([
            "msg" => trans("dashboard.error.authunticate.unauthunticate")
        ]);
    }
}
