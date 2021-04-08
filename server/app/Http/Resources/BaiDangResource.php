<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BaiDangResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "user" => $this->user->name,
            "tieude" => $this->tieude,
            "hinhanh" => $this->hinhanh,
            "loai" => $this->loai->ten_loai,
            "loai_id" => $this->loai->id,
            "gia" => $this->gia,
            "huong" => $this->huong,
            "isChoThue" => $this->isChoThue,
            "sophongngu" => $this->sophongngu,
            "sophongtam" => $this->sophongtam,
            "namxaydung" => $this->namxaydung,
            "diachi" => $this->diachi,
            "dientich" => $this->dientich,
            "thoigian" => $this->formattedCreatedDate(),
            "choduyet" => $this->choduyet,
            "trangthai" => $this->trangthai,
        ];
    }
}
