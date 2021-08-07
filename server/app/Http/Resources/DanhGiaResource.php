<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DanhGiaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user' => new UserResource( $this->user),
            'sao' => $this->sao,
            'noidung' => $this->noidung,
        ];
    }
}
