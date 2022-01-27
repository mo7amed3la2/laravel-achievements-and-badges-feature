<?php

namespace App\Models;

use App\Models\User;
use App\Models\Badge;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BadgeProgress extends Model
{
    use HasFactory;

    protected $casts = [
        'unlocked_at' => 'datetime',
    ];

    /**
     * Get the user.
     */
    public function user()
    {
        return $this->belongsto(User::class, 'user_id');
    }

    /**
     * Get the badge.
     */
    public function badge()
    {
        return $this->belongsto(Badge::class, 'badge_id');
    }

    public function isLocked()
    {
        if ($this->points < $this->badge->points) {
            return true;
        }
        return false;
    }

    public function isUnLocked()
    {
        return !$this->isLocked();
    }
}
