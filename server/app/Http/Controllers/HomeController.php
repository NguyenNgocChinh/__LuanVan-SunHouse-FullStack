<?php

namespace App\Http\Controllers;

use App\Models\BaiDang;
use App\Models\Loai;
use App\Models\TienNghi;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $baidangs = BaiDang::select('*')->orderBy('created_at', 'desc')->get();
        $raoban = BaiDang::select('*')->where('isChoThue', 0)->orderBy('created_at', 'desc')->get();
        $chothue = BaiDang::select('*')->where('isChoThue', 1)->orderBy('created_at', 'desc')->get();
        $ds_loai = Loai::all();
        $ds_tiennghi = TienNghi::all();
        return view(
            'nguoidung.trangchu',
            [
                'ds_loai' => $ds_loai,
                'baidangs' => $baidangs,
                'raobans' => $raoban,
                'chothues' => $chothue,
                'ds_tiennghi' => $ds_tiennghi
            ]
        );
    }
}
