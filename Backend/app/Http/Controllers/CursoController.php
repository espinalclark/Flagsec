<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CursoController extends Controller
{
    /**
     * Constructor: aplica middleware de autenticación y permisos
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');

        // Solo admin puede modificar cursos
        $this->middleware('can:manage-cursos')->except(['index', 'show']);
    }

    /**
     * Listar todos los cursos
     */
    public function index()
    {
        $cursos = Curso::select('id', 'title', 'description', 'image', 'created_at')
                        ->orderBy('created_at', 'desc')
                        ->get();

        return response()->json([
            'count'  => $cursos->count(),
            'cursos' => $cursos,
        ], 200);
    }

    /**
     * Mostrar un curso específico
     */
    public function show(Curso $curso)
    {
        return response()->json([
            'curso' => $curso->only(['id', 'title', 'description', 'image', 'created_at']),
        ], 200);
    }

    /**
     * Crear un nuevo curso (solo admin)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:150'],
            'description' => ['required', 'string', 'max:1000'],
            'image'       => ['nullable', 'url', 'max:255'],
        ]);

        $curso = Curso::create($validated);

        return response()->json([
            'message' => 'Curso creado exitosamente.',
            'curso'   => $curso,
        ], 201);
    }

    /**
     * Actualizar un curso (solo admin)
     */
    public function update(Request $request, Curso $curso)
    {
        $validated = $request->validate([
            'title'       => ['sometimes', 'string', 'max:150'],
            'description' => ['sometimes', 'string', 'max:1000'],
            'image'       => ['sometimes', 'url', 'max:255'],
        ]);

        $curso->update($validated);

        return response()->json([
            'message' => 'Curso actualizado exitosamente.',
            'curso'   => $curso,
        ], 200);
    }

    /**
     * Eliminar un curso (solo admin)
     */
    public function destroy(Curso $curso)
    {
        $curso->delete();

        return response()->json([
            'message' => 'Curso eliminado correctamente.',
        ], 200);
    }
}

