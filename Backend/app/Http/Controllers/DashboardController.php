<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Constructor: aplica middleware de autenticación y autorización
     */
    public function __construct()
    {
        // Solo usuarios autenticados
        $this->middleware('auth:sanctum');

        // Middleware opcional para roles
        $this->middleware('can:view-admin-dashboard')->only('admin');
        $this->middleware('can:view-student-dashboard')->only('student');
    }

    /**
     * Dashboard para estudiantes
     */
    public function student(Request $request)
    {
        $user = $request->user();

        // Datos seguros para el frontend
        $data = [
            'name'        => $user->name,
            'email'       => $user->email,
            'courses'     => $user->courses()->select('id', 'title', 'progress')->get(),
            'last_login'  => $user->last_login_at?->toDateTimeString(),
        ];

        return response()->json([
            'dashboard_type' => 'student',
            'data'           => $data,
        ], 200);
    }

    /**
     * Dashboard para administradores
     */
    public function admin(Request $request)
    {
        $user = $request->user();

        // Datos administrativos, solo lo mínimo necesario
        $data = [
            'name'       => $user->name,
            'email'      => $user->email,
            'total_users'=> \App\Models\User::count(),
            'active_users'=> \App\Models\User::where('is_active', true)->count(),
            'recent_signups' => \App\Models\User::latest()->take(5)->get(['id','name','email','created_at']),
        ];

        return response()->json([
            'dashboard_type' => 'admin',
            'data'           => $data,
        ], 200);
    }
}

