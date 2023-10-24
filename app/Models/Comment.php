<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Traits
use App\Traits\Relations\CommentRelations;

class Comment extends Model
{
    use HasFactory;
    use CommentRelations;

    protected $fillable = [
        'user_id',
        'video_id',
        'content'
    ];
}
