<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DanhGia extends Model
{
    use HasFactory;
    protected $table = "danhgia";
    protected $primaryKey = "id";
    protected $fillable = ['sao','user_id','noidung'];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

}
