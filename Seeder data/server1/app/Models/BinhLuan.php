<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BinhLuan extends Model
{
    use HasFactory;

    protected $table = "binhluan";
    protected $primaryKey = "id";

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id')->select(['id', 'name', 'sdt', 'username']);
    }

    public function baidang()
    {
        return $this->belongsTo('App\Models\BaiDang', 'baidang_id', 'id')->select(['id', 'tieude']);
    }

    // public function danhgia()
    // {
    //     return $this->belongsTo('App\Models\DanhGia', 'danhgia_id', 'id');
    // }

}