<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BaiDangResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "user" => $this->users->name,
            "userObject" => (object) new UserResource($this->users),
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
            "luotxem" => $this->luotxem,
            "douutien" => $this->douutien,
            "created_at" => $this->created_at,
            "bankinh" => $this->bankinh,
        ];
    }
}
