<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loai extends Model
{
    use HasFactory;

    protected $table = "loai";
    protected $primaryKey = "id";

    public function baidang()
    {
        return $this->hasMany('App\Models\BaiDang', 'loai_id', 'id');
    }

    public function usesTimestamps(): bool
    {
        return false;
    }

}
