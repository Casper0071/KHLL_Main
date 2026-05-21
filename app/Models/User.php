<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // admin of user
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Check if user is admin
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // Check if user has permission
    public function hasPermission($permission)
    {
        if ($this->isAdmin()) {
            return true;
        }

        $permissions = [
            'view_users' => false,
            'edit_users' => false,
            'delete_users' => false,
            'manage_agenda' => true,
            'manage_components' => true,
        ];

        return $permissions[$permission] ?? false;
    }
}
