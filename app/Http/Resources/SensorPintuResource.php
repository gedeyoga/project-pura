<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SensorPintuResource extends JsonResource
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
            'pura_id' => $this->pura_id,
            'gs_kode_sensor' => $this->gs_kode_sensor,
            'gs_nama' => $this->gs_nama,
            'gs_sensor_pintu' => $this->gs_sensor_pintu,
            'ping_at' => $this->ping_at,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->created_at->format('Y-m-d H:i:s'),
            'pura' => new PuraTransformer($this->whenLoaded('pura')),
        ];
    }
}
