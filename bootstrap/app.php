<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth.pemilik' => \App\Http\Middleware\CekLoginPemilik::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (HttpException $e, Request $request) {
            if ($e->getStatusCode() === 429) {
                $seconds = $e->getHeaders()['Retry-After'] ?? 30;

                session()->put('error', 'limit');
                session()->put('remaining', $seconds);
                session()->put('lockout_time', time() + $seconds);
                session()->save();

                return back();
            }
        });
    })->create();
