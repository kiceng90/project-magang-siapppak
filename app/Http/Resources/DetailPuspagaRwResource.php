<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DetailPuspagaRwResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $parent = parent::toArray($request);
        $data = [
            'file_sk' => FileResource::collection($this->fileSk),
            'ktp' => new FileResource($this->ktp),
        ];

        return  array_merge($parent, $data) ;
    }
}
