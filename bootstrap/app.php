<?php

use Illuminate\Foundation\Application;
use App\Http\Middleware\UserMiddleware;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\HospitalMiddleware;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin'=>AdminMiddleware::class,
            'hospital'=>HospitalMiddleware::class,
            'user'=>UserMiddleware::class
       ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();

if (getenv('VERCEL') === '1') {
    $storagePath = sys_get_temp_dir().'/laravel-storage';

    foreach ([
        'app/public',
        'framework/cache/data',
        'framework/sessions',
        'framework/testing',
        'framework/views',
        'logs',
    ] as $directory) {
        $path = $storagePath.'/'.$directory;

        if (! is_dir($path) && ! mkdir($path, 0755, true) && ! is_dir($path)) {
            throw new RuntimeException("Unable to create Laravel storage directory: {$path}");
        }
    }

    $app->useStoragePath($storagePath);
}

return $app;
