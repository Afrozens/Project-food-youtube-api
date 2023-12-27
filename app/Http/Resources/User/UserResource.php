<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'nickname' => $this->nickname,
            'email' => $this->email,
            'img' => $this->img,
            'img_path' => url($this->img_url),
            'admin' => $this->hasRole('admin') || $this->hasRole('Super Admin') ? true : false,
            'super' => $this->hasRole('Super Admin'),
        ];
    }
}
