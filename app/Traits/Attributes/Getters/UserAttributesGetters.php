<?php

namespace App\Traits\Attributes\Getters;

use Illuminate\Support\Facades\Storage;

trait UserAttributesGetters
{
	public function getImgAttribute()
	{
		if($this->img_url)
        	return '/storage/profile/' . $this->img_url;
		return null;
	}

	public function getIsAdminAttribute()
	{
		return $this->hasRole('admin');
	}
} 