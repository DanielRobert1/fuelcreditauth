<?php

namespace App\Http\Resources;
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
            'name' => $this->name,
            'email' => $this->email,
            'status' => $this->status,
            'created' => parseRequestTime($this->created_at)->toDayDateTimeString(),
            'created_at' => parseRequestTime($this->created_at)->getTimestamp(),
        ];
    }
}
