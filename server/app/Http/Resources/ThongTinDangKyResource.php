<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ThongTinDangKyResource extends JsonResource
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
            "id" => $this->id,
            "user" => $this->user->name,
            "loai" => $this->loai->ten_loai ?? null,
            "giamin" => $this->giamin,
            "giamax" => $this->giamax,
            "huong" => $this->huong,
            "isChoThue" => $this->isChoThue,
            "sophongngu" => $this->sophongngu,
            "sophongtam" => $this->sophongtam,
            "diachi" => $this->diachi,
            "dientichmin" => $this->dientichmin,
            "dientichmax" => $this->dientichmax,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
