<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TienNghiBaiDang extends Model
{
    use HasFactory;
    protected $table = "tiennghi-baidang";
    protected $primaryKey = "id";
    public $timestamps = false;
    public function baidang()
    {
        return $this->hasMany('App\Models\BaiDang', 'baidang_id', 'id');
    }
    public function tiennghi()
    {
        return $this->hasMany('App\Models\Tiennghi',  'id','tiennghi_id');
    }
}
