<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $table = "location";
    protected $primaryKey = "id";

    public function baidang()
    {
        return $this->hasMany('App\Models\BaiDang', 'baidang_id', 'id');
    }
}
