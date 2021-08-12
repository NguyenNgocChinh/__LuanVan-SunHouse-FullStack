<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\BaiDang;
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
        $xaid = $request->xaid;
        $strlenXaID = strlen($xaid);
        $duong = gettype($request->tenduong) == 'array' ? $request->tenduong['tenduong'] : $request->tenduong;
        if ($strlenXaID < 5) {
            for ($i = 1; $i <= 5 - $strlenXaID; $i++){
                $xaid = '0'. $xaid;
            }
        }
        $xa = XaPhuong::find($xaid);
        $post = BaiDang::find($request->baidang_id);
        $isTonTai = $xa != null ? Duong::where(['tenduong' => $duong, 'xaid' => $xaid])->first() : null;
        if ($isTonTai == null) {
            if ($xa != null) {
                $duong = new Duong();
                $duong->fill([
                    'tenduong' => $request->tenduong,
                    'xaid' => $xaid,
                ]);
                $duong->save();
                $post->duong_id = $duong->id;
                $post->save();
                return response()->json(
                    ['success' => 'Thêm đường thành công']
                );
            }
            else
            {
                return response()->json(
                    ['errors' => 'Không tìm thấy xã']
                );
            }
        }
        else{
            $post->duong_id = $isTonTai->id;
            $post->save();
            return response()->json(
                ['success' => 'Thêm đường vào bài đăng thành công']
            );
        }
    }
    public function toggleDuong($id_duong)
    {
        $duong = Duong::findOrFail((int)$id_duong);
        if ($duong != null) {
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
        if ($duong != null) {
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
