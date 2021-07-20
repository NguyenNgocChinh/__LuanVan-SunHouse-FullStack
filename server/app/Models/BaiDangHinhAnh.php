<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function PHPUnit\Framework\fileExists;

class BaiDangHinhAnh extends Model
{
    use HasFactory;

    protected $table = 'baidang-hinhanh';
    protected $primaryKey = 'id';

    public function usesTimestamps(): bool
    {
        return false;
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($hinhanh) {
            if(file_exists(public_path('images/upload/' . $hinhanh->filename)))
                unlink(public_path('images/upload/' . $hinhanh->filename));
        });
    }


}
