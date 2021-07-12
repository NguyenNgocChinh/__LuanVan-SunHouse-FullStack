<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BaiDang;
use App\Models\BinhLuan;
use Illuminate\Http\Request;

class Admin_IndexController extends Controller
{
    public function index()
    {

        $ChoDuyet = BaiDang::select('baidang.id', 'tieude', 'name', 'noidung')
            ->join('users', 'users.id', '=', 'user_id')
            ->where('choduyet', '=', '0')->get();
        $DaDuyet = BaiDang::where('choduyet', '=', '1')->get();
        $numDaDuyet = count($DaDuyet);
        $numChoDuyet = count($ChoDuyet);
        $numToTal = count(BaiDang::all());
        $numBinhLuan = count(BinhLuan::all());
        $data = [
            'numChoDuyet' => $numChoDuyet,
            'numDaDuyet' => $numDaDuyet,
            'numToTal' => $numToTal,
            'numBinhLuan' => $numBinhLuan,
            'choDuyets' => $ChoDuyet
        ];
        return view('admin.trangchuadmin', ['data' => $data]);
    }

    public function duyetBai($id)
    {
        $baidang = BaiDang::find($id);
        $baidang->choduyet = 1;
        return $baidang->update();
    }
}