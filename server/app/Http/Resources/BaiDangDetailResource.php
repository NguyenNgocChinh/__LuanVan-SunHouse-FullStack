<?php

namespace App\Http\Resources;

use App\Models\TienNghi;
use Illuminate\Http\Resources\Json\JsonResource;

class BaiDangDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $tiennghi = [] ;
        if (isset($this->tiennghi_baidang))
        {
            foreach ($this->tiennghi_baidang as $tn){
                $tiennghi[] = TienNghi::find($tn->tiennghi_id);
            }
        }
        return [
            "id" => $this->id,
            "user" => (object) [
                "id" => $this->user->id,
                "name" => $this->user->name,
                "sdt" =>$this->user->sdt,
                "profile_photo_url"=> $this->user->profile_photo_url,
                "profile_photo_path" => $this->user->profile_photo_path
            ],
            "noidung" => $this->noidung,
            "tieude" => $this->tieude,
            "hinhanh" => $this->hinhanh,
            "loai" => $this->loai->ten_loai,
            "gia" => $this->gia,
            "huong" => $this->huong,
            "isChoThue" => $this->isChoThue,
            "sophongngu" => $this->sophongngu,
            "sophongtam" => $this->sophongtam,
            "namxaydung" => $this->namxaydung,
            "diachi" => $this->diachi,
            "dientich" => $this->dientich,
            "tiennghi" => $tiennghi,
            "thoigian" => $this->formattedCreatedDate(),
            "ngaydang" => $this->created_at,
            "toadoX"=>$this->toadoX,
            "toadoY"=>$this->toadoY,

        ];
    }
}
