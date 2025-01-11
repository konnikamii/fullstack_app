<?php

// filepath: /d:/PhpFiles/vite_vue/backend2/app/Http/Kernel.php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        // Add middleware...
        // \App\Http\Middleware\CorsMiddleware::class,
        // \App\Http\Middleware\VerifyCsrfToken::class,
    ];

    // Other methods...
}
