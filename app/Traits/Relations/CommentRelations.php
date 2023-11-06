<?php

namespace App\Traits\Relations;

use App\Models\Video;
use App\Models\User;


trait CommentRelations
{

	public function user()
	{
	    return $this->belongsTo(User::class);
	}

	public function video()
	{
	    return $this->belongsTo(Video::class);
	}
}