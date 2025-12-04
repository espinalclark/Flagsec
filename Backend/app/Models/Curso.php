<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    /**
     * Atributos que se pueden asignar masivamente.
     * Protegemos contra Mass Assignment.
     */
    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',   // ruta segura a la imagen
        'slug',     // URL amigable
        'activo',   // booleano para activar/desactivar
        'user_id',  // creador del curso
    ];

    /**
     * Atributos ocultos para arrays/json
     */
    protected $hidden = [
        // si quieres ocultar datos sensibles
    ];

    /**
     * Casting de tipos.
     */
    protected $casts = [
        'activo' => 'boolean',
    ];

    /**
     * Relación con el usuario creador
     */
    public function creador()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relación con los estudiantes inscritos
     */
    public function estudiantes()
    {
        return $this->belongsToMany(User::class, 'curso_user')
                    ->withTimestamps(); // tabla pivot curso_user
    }

    /**
     * Mutator para generar slug seguro automáticamente
     */
    public function setTituloAttribute($value)
    {
        $this->attributes['titulo'] = $value;
        $this->attributes['slug'] = \Str::slug($value);
    }

    /**
     * Método para activar/desactivar curso
     */
    public function toggleActivo()
    {
        $this->activo = !$this->activo;
        $this->save();
    }

    /**
     * Validaciones de seguridad nivel DIOS
     */
    public static function reglasValidacion(): array
    {
        return [
            'titulo' => 'required|string|max:255|unique:cursos,titulo',
            'descripcion' => 'required|string|max:5000',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'user_id' => 'required|exists:users,id',
            'activo' => 'boolean',
        ];
    }
}

