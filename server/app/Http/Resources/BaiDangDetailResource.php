<?php

namespace App\Http\Resources;

use App\Models\TienNghi;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BaiDangDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "user" => (object) [
                "id" => $this->users->id,
                "name" => $this->users->name,
                "sdt" =>$this->users->sdt,
                "email" => $this->users->email,
                "sobaidang" => count($this->users->baidang),
                "profile_photo_url"=> $this->users->profile_photo_url,
                "profile_photo_path" => $this->users->profile_photo_path,
                "created_at" => $this->users->created_at
            ],
            "luotxem" => $this->luotxem,
            "noidung" => $this->noidung,
            "tieude" => $this->tieude,
            "hinhanh" => $this->hinhanh,
            "loai" => $this->loai->ten_loai,
            "trangthai" => $this->trangthai,
            "choduyet" => $this->choduyet,
            "gia" => $this->gia,
            "huong" => $this->huong,
            "isChoThue" => $this->isChoThue,
            "sophongngu" => $this->sophongngu,
            "sophongtam" => $this->sophongtam,
            "namxaydung" => $this->namxaydung,
            "diachi" => $this->diachi,
            "dientich" => $this->dientich,
            "tiennghi" => $this->tiennghi,
            "thoigian" => $this->formattedCreatedDate(),
            "toadoX"=>$this->toadoX,
            "toadoY"=>$this->toadoY,
            "created_at" => $this->created_at,
            "next_push" => $this->next_push
        ];
    }
}
