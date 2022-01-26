<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;

    public $with = ['nextAchievement'];
    
    public function nextAchievement()
    {
        return $this->belongsto(Achievement::class, 'next_achievement_id');
    }
}
