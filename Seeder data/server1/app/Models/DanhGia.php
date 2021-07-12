<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DanhGia extends Model
{
    use HasFactory;
    protected $table = "danhgia";
    protected $primaryKey = "id";

    public function user()
    {
        return $this->belongsTo('App\Models\User','id','user_id');
    }

    public function baidang(){
        return $this->belongsTo('App\Models\BaiDang','baidang_id','id');
    }
}
