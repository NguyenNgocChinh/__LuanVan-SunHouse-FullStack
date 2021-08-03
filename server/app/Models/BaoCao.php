<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaoCao extends Model
{
    use HasFactory;

    protected $table = 'baocao';

    public function baidang()
    {
        return $this->belongsTo(BaiDang::class)->select('id');
    }
}
