<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Relations\MessageRelations;

class Message extends Model
{
    use HasFactory;
    use MessageRelations;
    protected $fillable = [
        'user_id',
        'content',
        'name_user',
        'user_receiver',
        'user_sender'
    ];
}
