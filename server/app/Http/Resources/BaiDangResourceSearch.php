<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BaiDangResourceSearch extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */


    public function toArray($request)
    {
        $getBanKinh = function($x_from, $y_from, $x_to, $y_to) use ($request)
        {
            if ($request->banKinhOn == 'true') {
                $bankinh = DB::select("select ST_Distance_Sphere(ST_GeomFromText('point($x_from $y_from)',4326),(ST_GeomFromText('point($x_to $y_to)',4326))) as bankinh");
                return $bankinh[0]->bankinh / 1609.344;
            }
            return null;
        };
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
            "bankinh" => $getBanKinh($request->Y, $request->X, $this->toadoX, $this->toadoY),
            "bankinhtest" => 1,
        ];
    }
}
