<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Loai;

class ApiLoaiController extends Controller
{
    public function getAllLoai()
    {
        return response()->json(Loai::all());
    }
}
