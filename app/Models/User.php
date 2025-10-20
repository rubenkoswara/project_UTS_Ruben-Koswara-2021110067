<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail; // Non-aktifkan jika tidak diperlukan
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        // BARIS BARU WAJIB: Tambahkan kolom profil tambahan di sini
        'phone_number',
        'date_of_birth',
        'address',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            // BARIS BARU WAJIB: Cast tanggal lahir sebagai tipe data Date
            'date_of_birth' => 'date', 
        ];
    }
}
