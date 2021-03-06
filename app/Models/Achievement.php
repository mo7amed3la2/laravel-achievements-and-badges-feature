<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;

    const TYPE_COMMENT_WRITTEN = 'comment_written';
    const TYPE_LESSON_WATCHED = 'lesson_watched';
}
