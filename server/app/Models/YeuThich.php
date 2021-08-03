<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YeuThich extends Model
{
    use HasFactory;
    protected $table = "yeuthich";
    protected $primaryKey = "id";
    public $timestamps = false;

    public function baidang()
    {
        return $this->belongsTo(BaiDang::class, "baidang_id", "id");
    }
}
