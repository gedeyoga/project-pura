<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PuraTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $pura = parent::toArray($request);
        $pura['users'] = UserTransformer::collection($this->whenLoaded('users'));
        $pura['foto_pura'] = $this->whenLoaded('foto_pura');
        $pura['jenis_pura'] = new JenisPuraTransformer($this->whenLoaded('jenis_pura'));
        return $pura;
    }
}
