<?php

namespace App\Traits\Relations;

use App\Models\User;
use App\Models\Comment;
use App\Models\Tag;


trait VideoRelations
{
	public function user()
	{
	    return $this->belongsTo(User::class);
	}

	public function tags()
	{
	    return $this->belongsToMany(Tag::class, 'tag_video', 'video_id', 'tag_id');
	}

	public function comments()
	{
	    return $this->hasMany(Comment::class);
	}
}