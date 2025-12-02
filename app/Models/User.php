<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
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
        'role',        // role user (owner, staff, dll)
        'owner_id',    // relasi ke owner
        'google_id',   // id user dari Google
        'avatar',      // foto profil dari Google (optional)
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
            'password'          => 'hashed',
        ];
    }

    // ====== RELASI TAMBAHAN ======

    // kalau user ini karyawan, dia punya 1 owner
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    // kalau user ini owner, dia bisa punya banyak staff
    public function staff()
    {
        return $this->hasMany(User::class, 'owner_id');
    }
}
