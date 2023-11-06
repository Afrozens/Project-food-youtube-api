<?php

namespace App\Traits\Relations;

use App\Models\Video;

trait TagRelations
{
	public function videos()
	{
	    return $this->belongsToMany(Video::class, 'tag_video', 'tag_id', 'video_id');
	}
}