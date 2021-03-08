<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuanHuyen extends Model
{
    use HasFactory;

    protected $table = "quanhuyen";
    protected $primaryKey = "maqh";
    public $timestamps = false;

    public function xaphuong()
    {
        return $this->hasMany('App\Models\XaPhuong', "maqh", "maqh")->select("xaid", "name");
    }

}
