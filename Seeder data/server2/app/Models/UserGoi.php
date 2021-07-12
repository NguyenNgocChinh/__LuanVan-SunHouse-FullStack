<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserGoi extends Model
{
    use HasFactory;

    protected $table = "user-goi";
    protected $primaryKey = "id";
    public $timestamps = false;
}