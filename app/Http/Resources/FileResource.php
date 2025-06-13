<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Crypt;

class FileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $class = explode("\\",get_class($this->resource));
        $class = $class[count($class) - 1];
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'path' => $request->filled('full_link') && !$request->full_link ? $this->path : route('file.show', ['id' => Crypt::encrypt($this->id), 'model' => $class]),
            'size' => $this->size,
            'ext' => $this->ext,
            'isImage' => $this->is_image,
        ];

        return $data;
    }
}
