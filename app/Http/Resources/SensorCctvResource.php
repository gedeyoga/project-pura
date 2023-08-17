<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SensorCctvResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // $data = parent::toArray($request);
        // $data['pura'] = new PuraTransformer($this->whenLoaded('pura'));

        return [
            'id' => $this->id,
            'cctv_photo' => url($this->cctv_photo), 
            'cctv_status' => $this->cctv_status, 
            'pura_id' => $this->pura_id, 
            'gs_kode_sensor' => $this->gs_kode_sensor,
            'pura' => new PuraTransformer($this->whenLoaded('pura')),
        ];
    }
}
