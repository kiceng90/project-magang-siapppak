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
        $name = $this->name ?? null;
        if(!$name){
            switch ($this->id_role){
                case config('env.role.opd'):
                    $name = $this->opd->name ?? null;
                    break;
                case config('env.role.konselor'):
                    $name = $this->konselor->name ?? null;
                    break;
                default:
                    break;
            }
        }

        $result = [
            'id' => $this->id,
            'name' => $name,
            'username' => $this->username ?? null,
            'opd' => new OpdResource($this->whenLoaded('opd')),
            'konselor' => new KonselorResource($this->whenLoaded('konselor')),
        ];

        return $result;
    }
}
