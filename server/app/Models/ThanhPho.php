<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThanhPho extends Model
{
    use HasFactory;

    protected $table = "tinhthanhpho";
    public $timestamps = false;
    protected $primaryKey = "matp";

    public function quanhuyen()
    {
        return $this->hasMany("App\Models\QuanHuyen", "matp", "matp")->select('maqh', 'name');
    }
}
