<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Crypt;

class KonselorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $result = [
            'foto' => $this->photo ? route('file.show', ['id' => Crypt::encrypt($this->photo->id), 'model' => 'MKonselorFile']) : null,
            'id' => $this->id,
            'name' => $this->name,
            'phone_number' => $this->phone_number,
            'is_active' => $this->is_active,
        ];

        return $result;
    }
}
