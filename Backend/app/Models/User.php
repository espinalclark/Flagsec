<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Los atributos que se pueden asignar masivamente.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // admin, student, etc.
    ];

    /**
     * Los atributos que deben ser ocultos para arrays/json.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Los atributos que deben ser casteados a tipos nativos.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Establece el hash automático del password.
     */
    public function setPasswordAttribute($password)
    {
        if ($password) {
            $this->attributes['password'] = bcrypt($password); // Hash seguro
        }
    }

    /**
     * Verifica si el usuario tiene un rol específico.
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    /**
     * Relación con cursos (si tu sistema los tiene).
     */
    public function cursos()
    {
        return $this->hasMany(Curso::class);
    }

    /**
     * Relación con otros modelos si aplica (ej: logs de actividad).
     */
    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    /**
     * Métodos de verificación de permisos avanzados.
     */
    public function canAccess(string $permission): bool
    {
        // Aquí podrías integrar un sistema de permisos más granular
        // ejemplo: roles y permisos con pivot table
        return $this->role === 'admin' || in_array($permission, $this->getPermissions());
    }

    private function getPermissions(): array
    {
        // Simulación de permisos. En la realidad, los traes de DB.
        $permissions = [
            'student' => ['view_course', 'enroll_course'],
            'admin'   => ['create_course', 'edit_course', 'delete_course', 'manage_users'],
        ];

        return $permissions[$this->role] ?? [];
    }
}

