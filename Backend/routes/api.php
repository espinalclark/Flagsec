<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes - Nivel Dios
|--------------------------------------------------------------------------
| Rutas seguras para tu API.
| Se recomienda versionar la API (/api/v1/...) y proteger con middleware.
*/

/*
|--------------------------------------------------------------------------
| Autenticación
|--------------------------------------------------------------------------
*/
Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});

/*
|--------------------------------------------------------------------------
| Usuarios
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum'])->group(function () {

    // Solo admins pueden manejar usuarios
    Route::middleware(['role:admin'])->group(function () {
        Route::get('users', [UserController::class, 'index']);
        Route::get('users/{user}', [UserController::class, 'show']);
        Route::put('users/{user}', [UserController::class, 'update']);
        Route::delete('users/{user}', [UserController::class, 'destroy']);
    });

    // Perfil propio
    Route::get('me', [UserController::class, 'profile']);
});

/*
|--------------------------------------------------------------------------
| Cursos
|--------------------------------------------------------------------------
*/
Route::prefix('cursos')->middleware(['auth:sanctum'])->group(function () {

    // CRUD para administradores
    Route::middleware(['role:admin'])->group(function () {
        Route::post('/', [CursoController::class, 'store']);
        Route::put('{curso}', [CursoController::class, 'update']);
        Route::delete('{curso}', [CursoController::class, 'destroy']);
    });

    // Todos los usuarios pueden ver cursos activos
    Route::get('/', [CursoController::class, 'index']);
    Route::get('{curso}', [CursoController::class, 'show']);

    // Inscribirse y progreso
    Route::post('{curso}/inscribirse', [CursoController::class, 'inscribirse']);
    Route::post('{curso}/progreso', [CursoController::class, 'actualizarProgreso']);
});

/*
|--------------------------------------------------------------------------
| Fallback
|--------------------------------------------------------------------------
| Retorna 404 JSON para rutas no definidas
*/
Route::fallback(function(){
    return response()->json([
        'message' => 'Ruta API no encontrada'
    ], 404);
});

