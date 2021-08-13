<?php

namespace App\Models;

use App\Traits\FullTextSearch;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaiDang extends Model
{
    use HasFactory ; //FullTextSearch
    use SearchableTrait;
    use SoftDeletes;

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
    protected $searchable = [
        'columns' => [
            'users.sdt' => 20,
            'baidang.diachi' => 10,
            'baidang.tieude' => 5,
            'baidang.huong' => 3,
            'loai.ten_loai' => 4,
        ],
        'joins' => [
            'loai' => ['loai_id','loai.id'],
            'users' => ['user_id','users.id'],
        ],
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
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
    public function bibaocao()
    {
        return $this->hasMany(BaoCao::class, 'baidang_id', 'id')->rightJoin('users','users.id','=','baocao.user_id')
        ->select(['baocao.id','noidung','baocao.created_at','user_bibaocao','name','username','profile_photo_path','users.sdt']);
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

        });
    }
}
