<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use function App\Helpers\json;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: [
            __DIR__.'/../routes/admin.php',
            __DIR__.'/../routes/client.php',
        ],
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->renderable(function (ModelNotFoundException $e, $request) {
            return json('failed' , 'Model Not Found' ,'' ,404);
        });

        $exceptions->renderable(function (NotFoundHttpException $e, $request) {
            return json('failed' , 'The page or resource you requested could not be found' ,'' ,404);
         });

        $exceptions->renderable(function (MethodNotAllowedHttpException $e, $request) {
            return json('failed' , 'Method Not Allowed' ,'' ,405);
        });

        $exceptions->renderable(function (ValidationException $e, $request) {
            return json(__('response.failed'), 'Validation Failed', $e->errors() , 422);
        });

        $exceptions->renderable(function (AuthenticationException $e, $request) {
            return json('failed' , 'Unauthenticated' ,'' , 401);
        });

        $exceptions->renderable(function (AuthorizationException $e, $request) {
            return json('failed' , 'Unauthorized' ,'' , 403);
        });

        $exceptions->renderable(function (RequestException $e, $request) {
            return json('failed' , 'Invalid Request' ,'' , 400);
        });

//        $exceptions->renderable(function (\Throwable $e, $request)   {
//            return json('failed' , 'Internal Server Error' ,'' , 500);
//        });
    })->create();
