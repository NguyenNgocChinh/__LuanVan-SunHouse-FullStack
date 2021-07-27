<?php

namespace App\Models;

use App\Traits\FullTextSearch;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
class BaiDang extends Model
{
    use HasFactory, FullTextSearch;

    protected $table = "baidang";
    protected $primaryKey = "id";
    protected $fillable = [
        'user_id',
        'tieude',
        'noidung',
        'loai_id',
        'gia',
        'trangthai',
        'huong',
        'isChoThue',
        'sophongngu',
        'sophongtam',
        'namxaydung',
        'diachi',
        'toadoX',
        'toadoY',
        'choduyet',
        'dientich',
    ];
    /**
     * The columns of the full text index
     */
    protected $searchable = [
        'diachi',
        'tieude'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function loai()
    {
        return $this->belongsTo('App\Models\Loai', 'loai_id', 'id');
    }

    public function danhgia()
    {
        return $this->hasMany('App\Models\DanhGia', 'baidang_id', 'id');
    }

    public function show_new_post()
    {
        return $this->orderBy('created_at', 'desc')->limit(5)->get();
    }

    public function binhluan()
    {
        return $this->hasMany('App\Models\BinhLuan', 'baidang_id', 'id');
    }

    public function tiennghi()
    {
        return $this->belongsToMany(TienNghi::class, 'tiennghi-baidang', 'baidang_id', 'tiennghi_id');
    }
    public function tiennghiBaiDang(){
        return $this->hasMany(TienNghiBaiDang::class, 'baidang_id', 'id');
    }
    public function hinhanh()
    {
        return $this->hasMany('App\Models\BaiDangHinhAnh', 'baidang_id', 'id')->select('filename','id');
    }

    public function getPrice()
    {
        $max = $this->max('gia')->get();
        return $max;
    }

    public function formattedCreatedDate()
    {
        $today = new DateTime(date("Y-m-d H:i:s"));
        $this->created_at = new DateTime(date($this->created_at));

        $created_at = $this->created_at;
        $time = $created_at->diff($today);

        $year = $time->y;
        $month = $time->m;
        $days = $time->d;
        $hours = $time->h;
        $minute = $time->i;
        $second = $time->s;
        if ($year > 0) {
            return $year . " năm trước";
        } else if ($month > 0) {
            return $month . " tháng trước";
        } else if ($days > 0) {
            return $days . " ngày trước";
        } else if ($hours > 0) {
            return $hours . " giờ trước";
        } else if ($minute > 0) {
            return $minute . " phút trước";
        } else if ($second > 0) {
            return $second . " giây trước";
        } else
            return $created_at;
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($baidang) {
            foreach ($baidang->tiennghiBaiDang as $tiennghi) {
                $tiennghi->delete();
            }
//            foreach ($baidang->binhluan as $binhluan) {
//                $binhluan->delete();
//            }
Log::info('Bai Dang Hinh Anh '.$baidang->hinhanh);
            foreach ($baidang->hinhanh as $hinhanh) {
                Log::info($hinhanh);
               $kq = $hinhanh->delete();
               Log::info("kq " . $kq);
            }
        });
    }
}
