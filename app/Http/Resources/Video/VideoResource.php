<?php

namespace App\Http\Resources\Video;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Tag\TagResource;

class VideoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $has = request()->get('has') ?? [];
        return [
            'id' => $this->id,
            'video_data' => $this->video_data,
            'tags' => $this->tags->whereIn('id', $has)->map(function($tag) {
                return new TagResource($tag);
            }),
            'tags_ids' => $this->tags->pluck('id'),
            'title' => $this->title,
            'description' => $this->description,
            'videoId' => $this->videoId,
            'has_more' => $this->tags->whereNotIn('id', $has)->map(function($tag) {
                return new TagResource($tag);
            }),
        ];
    }
}
