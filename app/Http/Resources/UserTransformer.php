<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $user = parent::toArray($request);
        if(isset($user['password'])) {
            unset($user['password']);
        }
        $user['roles'] = RoleTransformer::collection($this->whenLoaded('roles'));
        $user['pura'] = PuraTransformer::collection($this->whenLoaded('pura'));
        
        return $user;
    }
}
