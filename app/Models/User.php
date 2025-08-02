<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    const ROLE_ADMIN = 'admin';
    const ROLE_BIBLIOTECARIO = 'bibliotecario';
    const ROLE_CLIENTE = 'cliente';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'debit',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Métodos para verificar o papel do usuário
    public function isAdmin() {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isBibliotecario() {
        return $this->role === self::ROLE_BIBLIOTECARIO;
    }

    public function isCliente() {
        return $this->role === self::ROLE_CLIENTE;
    }

    public function books()
    {
        return $this->belongsToMany(Book::class, 'borrowings')
                    ->withPivot('id', 'borrowed_at', 'returned_at')
                    ->withTimestamps();
    }
}
