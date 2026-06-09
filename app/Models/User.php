<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'nama',
        'username',
        'email',
        'password',
        'bio',
        'instagram',
        'initials',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    // Auto-generate initials when creating
    protected static function booted(): void
    {
        static::creating(function (User $user) {
            if (empty($user->initials)) {
                $words = explode(' ', trim($user->nama));
                $initials = '';
                foreach (array_slice($words, 0, 2) as $word) {
                    $initials .= strtoupper(mb_substr($word, 0, 1));
                }
                $user->initials = $initials ?: 'U';
            }
        });
    }

    // ── Relations ──
    public function donasi()
    {
        return $this->hasMany(Donasi::class, 'user_id');
    }

    public function overlaySetting()
    {
        return $this->hasOne(OverlaySetting::class, 'user_id');
    }

    // ── Accessors ──
    public function getDonateUrlAttribute(): string
    {
        return 'Qeqink.id/' . $this->username;
    }
}
