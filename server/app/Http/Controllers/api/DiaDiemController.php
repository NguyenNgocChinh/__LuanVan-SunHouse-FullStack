<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\QuanHuyen;
use App\Models\ThanhPho;

class DiaDiemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function thanhpho()
    {
        return ThanhPho::select("matp", "name")->get();
    }

    public function quanhuyen($id_thanhpho)
    {
        $tp = ThanhPho::find((int)$id_thanhpho);
        $qh = $tp->quanhuyen;
        return $qh;
    }

    public function xaphuong($id_quanhuyen)
    {
        $qh = QuanHuyen::find((int)$id_quanhuyen);
        $xa = $qh->xaphuong;
        return $xa;
    }
}
