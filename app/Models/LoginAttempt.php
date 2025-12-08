<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class LoginAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'ip_address',
        'attempts',
        'locked_until',
        'last_attempt_at',
    ];

    protected $casts = [
        'locked_until' => 'datetime',
        'last_attempt_at' => 'datetime',
    ];

    /**
     * Cek apakah masih terkunci
     */
    public function isLocked(): bool
    {
        return $this->locked_until && Carbon::now()->lt($this->locked_until);
    }

    /**
     * Dapatkan sisa waktu lock dalam menit
     */
    public function remainingLockTime(): int
    {
        if (!$this->isLocked()) {
            return 0;
        }

        return Carbon::now()->diffInMinutes($this->locked_until, false);
    }

    /**
     * Reset attempts
     */
    public function reset()
    {
        $this->update([
            'attempts' => 0,
            'locked_until' => null,
            'last_attempt_at' => null,
        ]);
    }

    /**
     * Increment attempts
     */
    public function incrementAttempts()
    {
        $this->increment('attempts');
        $this->update(['last_attempt_at' => now()]);
    }

    /**
     * Lock account
     */
    public function lockAccount(int $minutes = 15)
    {
        $this->update([
            'locked_until' => now()->addMinutes($minutes),
        ]);
    }
}