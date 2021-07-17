<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class XaPhuong extends Model
{
    use HasFactory;

    protected $table = "xaphuongthitran";
    protected $primaryKey = "xaid";
    public $timestamps = false;
    public function duong()
    {
        return $this->hasMany('App\Models\Duong', "xaid", "xaid")->select("id", "tenduong");
    }

}
