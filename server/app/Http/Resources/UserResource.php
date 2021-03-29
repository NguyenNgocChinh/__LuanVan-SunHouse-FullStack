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
            'baidang' => $this->baidang->count(),
            'trangthai' => $this->trangthai,
            'vaitro' => $this->vaitro,
            'email' => $this->email,
        ];
    }
}
