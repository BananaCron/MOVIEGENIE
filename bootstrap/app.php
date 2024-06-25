<?php

require_once __DIR__.'/../vendor/autoload.php';

(new Laravel\Lumen\Bootstrap\LoadEnvironmentVariables(
    dirname(__DIR__)
))->bootstrap();

date_default_timezone_set(env('APP_TIMEZONE', 'UTC'));

$app = new Laravel\Lumen\Application(
    dirname(__DIR__)
);

$app->withFacades(); // Enable facades for easier access to Laravel components

$app->withEloquent(); // Enable Eloquent ORM for database operations

use Illuminate\Validation\DatabasePresenceVerifier;

// Bind a custom presence verifier for database validation
$app->bind('Illuminate\Contracts\Validation\PresenceVerifier', function ($app) {
    return new DatabasePresenceVerifier($app['db']->connection());
});

// Bind the UserService to the container
$app->bind('App\Services\UserService', function ($app) {
    return new \App\Services\UserService();
});

// Register the exception handler and console kernel
$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

// Register configuration files
$app->configure('jwt'); // Configuration for JWT Auth
$app->register(Tymon\JWTAuth\Providers\LumenServiceProvider::class); // Register JWTAuth service provider
$app->configure('app'); // Application configuration
$app->configure('auth'); // Authentication configuration

// Register middleware
$app->routeMiddleware([
    'auth' => App\Http\Middleware\Authenticate::class,
    'jwt.auth' => Tymon\JWTAuth\Http\Middleware\Authenticate::class,
    'jwt.refresh' => Tymon\JWTAuth\Http\Middleware\RefreshToken::class,
]);

// Register service providers
$app->register(Tymon\JWTAuth\Providers\LumenServiceProvider::class); // JWTAuth service provider
$app->register(App\Providers\JwtAuthServiceProvider::class); // Custom JWTAuth service provider
$app->register(App\Providers\AppServiceProvider::class); // Application service provider
$app->register(App\Providers\AuthServiceProvider::class); // Authentication service provider

// Load application routes
$app->router->group([
    'namespace' => 'App\Http\Controllers',
], function ($router) {
    require __DIR__.'/../routes/web.php'; // Load routes from web.php file
});

return $app;
