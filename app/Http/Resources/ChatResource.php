<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if (is_null($this->resource) || is_bool($this->resource)) return [];

        return [
            "id"            => $this->resource->getKey(),
            "content"       => $this->resource->content,
            "user"          => new UserResource($this->resource->user),
            "created_by"    => User::query()->find($this->resource->created_by,["id","name"]),
            "created_at"    => $this->resource->created_at->toDateTimeString(),
            "updated_at"    => $this->resource->updated_at->toDateTimeString(),
        ];
    }
}
