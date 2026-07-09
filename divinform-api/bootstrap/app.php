<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__ . '/../routes/api.php',
        apiPrefix: 'api',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Middleware alias
        $middleware->alias([
            'auth.jwt' => \App\Http\Middleware\JwtMiddleware::class,
            'role'     => \App\Http\Middleware\RoleMiddleware::class,
        ]);

        // CORS global pour toutes les routes API
        $middleware->api(prepend: [
            \Illuminate\Http\Middleware\HandleCors::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Réponses JSON pour toutes les exceptions API
        $exceptions->render(function (\Throwable $e, $request) {
            if (! ($request->is('api/*') || $request->expectsJson())) {
                return null; // laisser le handler par défaut traiter
            }

            if ($e instanceof ModelNotFoundException || $e instanceof NotFoundHttpException) {
                return response()->json(['message' => 'Ressource introuvable.'], 404);
            }

            if ($e instanceof ValidationException) {
                return response()->json([
                    'message' => 'Données invalides.',
                    'errors'  => $e->errors(),
                ], 422);
            }

            if ($e instanceof AuthenticationException) {
                return response()->json(['message' => 'Non authentifié.'], 401);
            }

            $status  = method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500;
            $message = app()->isProduction() ? 'Erreur interne du serveur.' : $e->getMessage();

            return response()->json(['message' => $message], $status);
        });
    })
    ->create();
