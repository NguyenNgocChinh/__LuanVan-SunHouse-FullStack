<?php

namespace App\Http\Controllers;

use App\Models\ThongTinDangKy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThongTinDangKyController extends Controller
{
    public function store(Request $request)
    {
        $flag = true;
        foreach ($request->all() as $item){
            if ($item != null)
                $flag = false;
        }
        if ($flag)
            return response()->json([
                'fail' => 'Thông tin đăng ký phải có ít nhất 1 tiêu chí.'
            ]);
        $ttdkOfUser = ThongTinDangKy::where('user_id', Auth::user()->id)
            ->where('giamin', $request->giamin)
            ->where('giamax', $request->giamax)
            ->where('dientichmin', $request->dientichmin)
            ->where('dientichmax', $request->dientichmax)
            ->where('huong', $request->huong)
            ->where('loai_id', $request->loai_id)
            ->where('sophongngu', $request->sophongngu)
            ->where('sophongtam', $request->sophongtam)
            ->where('isChoThue', $request->isChoThue)
            ->where('diachi', $request->diachi)
            ->get();

        if (count($ttdkOfUser) > 0) {
            return response()->json([
                'fail' => 'Thông tin đăng ký này đã được bạn đăng ký trước đó.'
            ]);
        }
        $thongtindangky = new ThongTinDangKy();
        $arr = [
            'user_id' => Auth::user()->id,
            'giamin' => $request->giamin,
            'giamax' => $request->giamax,
            'dientichmin' => $request->dientichmin,
            'dientichmax' => $request->dientichmax,
            'huong' => $request->huong,
            'loai_id' => $request->loai_id,
            'sophongngu' => $request->sophongngu,
            'sophongtam' => $request->sophongtam,
            'isChoThue' => $request->isChoThue,
            'diachi' => $request->diachi,
        ];
        $thongtindangky->fill($arr);
        $thongtindangky->save();
        return response()->json([
            'success' => 'Đăng ký nhận tin thành công'
        ]);
    }
}
