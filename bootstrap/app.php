<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Log every exception
        $exceptions->report(function (Throwable $e) {
            Log::error($e->getMessage(), ['exception' => $e]);

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        })->stop();

        // Rendering exceptions as JSON if request is from API routes
        $exceptions->shouldRenderJsonWhen(function (Request $request, Throwable $e) {
            if ($request->is('api/*')) {
                return true;
            }

            return $request->expectsJson();
        });

        $exceptions->render(function (ValidationException $e, Request $request) {
            Log::error('Validation Error', [
                'url' => $request->url(),
                'errors' => $e->getMessage(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => $e->validator->errors()
            ], 422);
        });

        $exceptions->render(function (AuthenticationException $e, Request $request) {
            Log::error('Authentication Error', [
                'url' => $request->url(),
                'errors' => $e->getMessage(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 401);
        });

    })->create();
