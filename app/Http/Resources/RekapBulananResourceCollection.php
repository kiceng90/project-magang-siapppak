<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class RekapBulananResourceCollection extends ResourceCollection
{
    protected $age_category;

    public function age_category($val){
        // anak = 1; dewasa = 2;
        $val = $val == 'anak' ? 1 : 2;
        $this->age_category = $val;
        return $this;
    }

    public function toArray($request){
        return $this->collection->map(function(RekapBulananResource $resource) use($request){
            return $resource->age_category($this->age_category)->toArray($request);
        })->all();
    }
}
