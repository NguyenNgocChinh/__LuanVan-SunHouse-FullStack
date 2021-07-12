<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThongTinDangKy extends Model
{
    use HasFactory;

    use HasFactory;

    protected $table = "thongtindangky";
    protected $primaryKey = "id";
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'giamin',
        'giamax',
        'dientichmin',
        'dientichmax',
        'huong',
        'loai_id',
        'sophongngu',
        'sophongtam',
        'isChoThue',
        'diachi',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function loai()
    {
        return $this->belongsTo('App\Models\Loai', 'loai_id', 'id');
    }
}
