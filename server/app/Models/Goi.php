<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goi extends Model
{
    use HasFactory;

    protected $table = "goi";
    protected $primaryKey = "id";
    public $timestamps = false;
}