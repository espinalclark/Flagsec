<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserCurso extends Pivot
{
    /**
     * Atributos asignables
     */
    protected $fillable = [
        'user_id',
        'curso_id',
        'progreso',     // % completado
        'fecha_inicio',
        'fecha_finalizacion',
    ];

    /**
     * Casting de tipos
     */
    protected $casts = [
        'progreso' => 'integer',
        'fecha_inicio' => 'datetime',
        'fecha_finalizacion' => 'datetime',
    ];

    /**
     * Relación al usuario
     */
    public function usuario()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    /**
     * Relación al curso
     */
    public function curso()
    {
        return $this->belongsTo(\App\Models\Curso::class, 'curso_id');
    }

    /**
     * Actualiza el progreso de manera segura
     */
    public function actualizarProgreso(int $valor)
    {
        $valor = max(0, min(100, $valor)); // aseguramos entre 0 y 100
        $this->progreso = $valor;
        $this->save();
    }

    /**
     * Marcar curso como finalizado
     */
    public function marcarFinalizado()
    {
        $this->progreso = 100;
        $this->fecha_finalizacion = now();
        $this->save();
    }

    /**
     * Reglas de validación nivel Dios
     */
    public static function reglasValidacion(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'curso_id' => 'required|exists:cursos,id',
            'progreso' => 'nullable|integer|min:0|max:100',
            'fecha_inicio' => 'nullable|date',
            'fecha_finalizacion' => 'nullable|date|after_or_equal:fecha_inicio',
        ];
    }
}

