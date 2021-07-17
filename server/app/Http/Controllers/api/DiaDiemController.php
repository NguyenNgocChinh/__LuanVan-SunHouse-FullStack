<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Duong;
use App\Models\QuanHuyen;
use App\Models\ThanhPho;
use App\Models\XaPhuong;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class DiaDiemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function thanhpho()
    {
        return ThanhPho::select("matp", "name")->get();
    }
    public function quanhuyen($id_thanhpho)
    {
        $tp = ThanhPho::findOrFail((int)$id_thanhpho);
        $qh = $tp->quanhuyen;
        return $qh;
    }
    public function xaphuong($id_quanhuyen)
    {
        $qh = QuanHuyen::findorFail((int)$id_quanhuyen);
        $xa = $qh->xaphuong;
        return $xa;
    }
    public function duong($id_xaphuong)
    {
        $qh = XaPhuong::findOrFail((int)$id_xaphuong);
        $duongs = $qh->duong;
        return $duongs;
    }
    public function addDuong(Request $request)
    {
        $xa = XaPhuong::findOrFail((int)$request->id_xaphuong);
        if($xa != null){
            DB::table('duong')->insert([
                'tenduong' => $request->tenduong,
                'xaid' => $xa->id,
            ]);
            return response()->json(
                ['success' => 'Thêm đường thành công']
            );
        }
        return response()->json(
            ['error' => 'Không tìm thấy xã']
        );
    }
    public function toggleDuong($id_duong)
    {
        $duong = Duong::findOrFail((int)$id_duong);
        if($duong != null){
            $duong->choduyet = !$duong->choduyet;
            $duong->update();
            return response()->json(
                ['success' => 'Cập nhật thành công']
            );
        }
        return response()->json(
            ['error' => 'Cập nhật thất bại']
        );
    }
    public function deleteDuong($id_duong)
    {
        $duong = Duong::findOrFail((int)$id_duong);
        if($duong != null){
            $duong->delete();
            return response()->json(
                ['success' => 'Xóa thành công']
            );
        }
        return response()->json(
            ['error' => 'Không tìm thấy đường']
        );
    }
}
