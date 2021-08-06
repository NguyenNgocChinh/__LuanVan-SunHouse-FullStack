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
use Illuminate\Support\Facades\Log;

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
        $isTonTai = Duong::where(['tenduong' => $request->tenduong, 'baidang_id' => $request->baidang_id])->get();
        Log::info("isTonTai " . $isTonTai);
        if(count($isTonTai) > 0){
            return true;
        }
        if($xa != null){
            $xaid = $xa->xaid;
            if(strlen($xaid) < 5){
                for($i = 1; $i <= 5 - strlen($xaid); $i++)
                    $xaid = substr_replace($xaid, '0', 0, 0);
            }
            $duong = new Duong();
            $duong->fill([
                'tenduong' => $request->tenduong,
                'xaid' => $xaid,
                'baidang_id' => $request->baidang_id
            ]);
            $duong->save();
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
