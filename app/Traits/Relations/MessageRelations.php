<?php

namespace App\Traits\Relations;

use App\Models\User;

trait MessageRelations
{

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
