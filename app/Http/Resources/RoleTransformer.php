<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\ConditionallyLoadsAttributes;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleTransformer extends JsonResource
{
    use ConditionallyLoadsAttributes;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data =  [
            'id' => $this->id,
            'name' => $this->name,
            'created_at' => $this->created_at->format('Y-m-d H:i'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i'),
            'permissions' => $this->whenLoaded('permissions'),
        ];

        $data = $this->filter($data);


        if (isset($data['permissions'])) {
            // dd($data);
            if ($data['permissions']->count() > 0) {
                $permissions = $data['permissions']->map(function ($item) {
                    $group_name = explode('.', $item->name);
                    return [
                        'module' => $group_name[0],
                        'name' => $item->name,
                        'allow' => true,
                    ];
                })->groupBy('module');

                $data['permissions'] = $permissions;
            }
        }

        return $data;
    }
}
