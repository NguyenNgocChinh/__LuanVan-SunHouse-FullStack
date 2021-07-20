<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Duong extends Model
{
    use HasFactory;
    protected $table = "duong";
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $fillable = [
        'tenduong',
        'xaid',
    ];
}
