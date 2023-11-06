<?php

namespace App\Traits\Attributes\Getters;

use Alaouy\Youtube\Facades\Youtube;

trait VideoAttributesGetters
{
	public function getVideoDataAttribute()
	{
		$data = [];
		$data['url'] = '//www.youtube.com/embed/' . $this->videoId;		
		$video_info = Youtube::getVideoInfo($this->videoId);
		
		if(!is_bool($video_info)) {
			$thumbnails = $video_info->snippet->thumbnails;
			if(property_exists($thumbnails, 'standard')) {
				$data['thumbnail'] = $thumbnails->standard->url;
			} else if(property_exists($thumbnails, 'medium')) {
				$data['thumbnail'] = $thumbnails->medium->url;
			} else if(property_exists($thumbnails, 'maxres')) {
				$data['thumbnail'] = $thumbnails->maxres->url;
			} else if(property_exists($thumbnails, 'high')) {
				$data['thumbnail'] = $thumbnails->high->url;
			} else {
				$data['thumbnail'] = $thumbnails->default->url;
			}
		} else {
			$data['thumbnail'] = asset('img/video-not-found.png');
		}
		return $data;
	}
}