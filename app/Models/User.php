<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Các thuộc tính được phép điền
    protected $fillable = [
        'name',
        'email',
        'password',
        'elo',
    ];

    // Ẩn thuộc tính khi truy xuất
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Giá trị mặc định
    protected $attributes = [
        'elo' => 1000,
    ];

    // Mật khẩu sẽ được hash khi truy xuất để tham chiếu
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}
