<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Traits
use App\Traits\Relations\TagRelations;

class Tag extends Model
{
    use HasFactory;
    use TagRelations;

    protected $fillable = [
        'name'
    ];
}
