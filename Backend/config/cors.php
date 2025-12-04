<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Rutas a permitir (origins)
    |--------------------------------------------------------------------------
    */
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    /*
    |--------------------------------------------------------------------------
    | Orígenes permitidos
    |--------------------------------------------------------------------------
    | Solo los dominios que necesiten acceder a tu backend.
    | Evita usar '*' en producción.
    */
    'allowed_origins' => [
        env('FRONTEND_URL', 'http://localhost:5173'),
        // Agrega otros dominios confiables si es necesario
    ],

    /*
    |--------------------------------------------------------------------------
    | Métodos HTTP permitidos
    |--------------------------------------------------------------------------
    */
    'allowed_methods' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],

    /*
    |--------------------------------------------------------------------------
    | Encabezados permitidos
    |--------------------------------------------------------------------------
    | Solo los que tu frontend realmente necesita.
    */
    'allowed_headers' => ['Content-Type', 'X-Requested-With', 'Authorization', 'Accept', 'Origin'],

    /*
    |--------------------------------------------------------------------------
    | Encabezados expuestos
    |--------------------------------------------------------------------------
    */
    'exposed_headers' => ['Authorization'],

    /*
    |--------------------------------------------------------------------------
    | Credenciales
    |--------------------------------------------------------------------------
    | true si necesitas enviar cookies o Authorization headers
    */
    'supports_credentials' => true,

    /*
    |--------------------------------------------------------------------------
    | Max Age
    |--------------------------------------------------------------------------
    | Cache de preflight en segundos
    */
    'max_age' => 3600,

];

