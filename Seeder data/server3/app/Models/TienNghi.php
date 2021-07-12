<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TienNghi extends Model
{
    use HasFactory;
    protected $table = "tiennghi";
    protected $primaryKey = "id";
    public $timestamps = false;
    public function baidang()
    {
        return $this->hasMany('App\Models\BaiDang', 'tiennghi_id', 'id');
    }
}