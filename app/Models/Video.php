<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Traits
use App\Traits\Relations\VideoRelations;
use App\Traits\Attributes\Getters\VideoAttributesGetters;

class Video extends Model
{
    use HasFactory;
    use VideoRelations;
    use VideoAttributesGetters;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'videoId',
        'code',
        'status'
    ];


    protected $appends = [
        'video_data'
    ];
}
