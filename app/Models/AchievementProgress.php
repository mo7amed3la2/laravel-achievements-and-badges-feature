<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use App\Traits\Achiever;
use App\Models\Achievement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AchievementProgress extends Model
{
    use HasFactory, Achiever;

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
     * Get the achievement.
     */
    public function achievement()
    {
        return $this->belongsto(Achievement::class, 'achievement_id');
    }

    public function isLocked()
    {
        if ($this->points < $this->achievement->points) {
            return true;
        } 
        return false;
    }

    public function isUnLocked()
    {
        return !$this->isLocked();
    }
}
