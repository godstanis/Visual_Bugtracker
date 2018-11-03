<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        self::withoutWrapping(); // {"data":[...]} wrapping remove for this response.

        $user = [
            'name' => $this->name,
            'email' => $this->email,
            'profile_image_url' => $this->imageLink(),
            'profile_url' => route('user', ['user' => $this])
        ];

        return $user;
    }
}
