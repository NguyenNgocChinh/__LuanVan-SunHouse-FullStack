<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id' => $this->id,
            'username' => $this->username,
            'name' => $this->name,
            'baidang' => $this->baidang->count(),
            'baidangDaDuyet' => $this->baidang->where('trangthai', 1)->where('choduyet', 0)->count(),
            'trangthai' => $this->trangthai,
            'vaitro' => $this->vaitro,
            'email' => $this->email,
            'sdt' => $this->sdt,
            'profile_photo_path' => $this->profile_photo_path,
            'profile_photo_url' => $this->profile_photo_url,
            'service' => $this->social
        ];
    }
}
