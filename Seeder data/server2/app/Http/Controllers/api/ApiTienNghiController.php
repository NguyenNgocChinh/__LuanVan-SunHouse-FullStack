<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\TienNghi;

class ApiTienNghiController extends Controller
{
    public function getAllTienNghi()
    {
        return response()->json(TienNghi::all());
    }
}
