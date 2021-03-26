<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\BaiDang;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index()
    {
        return DB::select('CALL popup_bando()');
    }
    public function getGia(){
        $maxPrice = BaiDang::max('gia');
        $minPrice = BaiDang::min('gia');

        return [
            'min' => $minPrice,
            'max' => $maxPrice,
        ];
    }
    public function getDienTich(){
        $minSqrt = BaiDang::min('dientich');
        $maxSqrt = BaiDang::max('dientich');

        return [
            'min' => $minSqrt,
            'max' => $maxSqrt,
        ];
    }
}
