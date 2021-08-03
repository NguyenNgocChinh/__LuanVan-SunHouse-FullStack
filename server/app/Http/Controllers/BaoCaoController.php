<?php

namespace App\Http\Controllers;

use App\Models\BaiDang;
use App\Models\BaoCao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BaoCaoController extends Controller
{
    public function getAllBaoCao()
    {
        return response()->json(BaoCao::all());
    }
    public function getBaiDangBaoCaoForUser()
    {
        $user = Auth::user();
        $baocaos = $user->baocao;
        $temp = $baocaos->implode('baidang_id', ',');
        Log::info("sdsadad " . $temp);
        $listIDPost = explode(',', trim($temp));
        $baidangs = BaiDang::whereIn('id', $listIDPost)->get();
        Log::info("count " . count($baidangs));
        for ($i = 0; $i < count($baidangs); $i++) {
            for ($j = 0; $j < count($baidangs); $j++) {
                if ($baidangs[$i]->id == $baocaos[$j]->baidang_id) {
                    $baidangs[$i]->noidungbaocao = $baocaos[$j]->noidung;
                    $baidangs[$i]->ngaybaocao = $baocaos[$j]->created_at->format('d/m/Y H:i:s');
                    $baidangs[$i]->hinhanh = $baidangs[$j]->hinhanh;
                    $baidangs[$i]->idbaocao = $baocaos[$j]->id;
                    break;
                }
            }
        }
        return response()->json($baidangs);
    }
    public function storeBaoCao(Request $request)
    {
        $request->validate([
            'noidung' => 'required|min:40',
            'baidang_id' => 'required'
        ], [
            'noidung.required' => 'Nội dung báo cáo không được rỗng',
            'noidung.min' => 'Nội dung báo cáo ít nhất 40 ký tự',
            'baidang_id.required' => 'Mã bài đăng không được rỗng',
        ]);
        $isTonTai = BaoCao::where(['user_id' => Auth::user()->id, 'baidang_id' => $request->baidang_id])->get();
        if (count($isTonTai) > 1) {
            return response()->json([
                'errors' => 'Bạn đã báo cáo bài đăng trước đó'
            ]);
        }
        $baocao = new BaoCao();
        $baocao->user_id = Auth::user()->id;
        $baocao->noidung = $request->noidung;
        $baocao->baidang_id = $request->baidang_id;
        $baocao->save();

        return response()->json([
            'success' => 'Báo cáo bài đăng thành công'
        ]);
    }
    public function deleteBaoCao(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);
        $baocao = BaoCao::findOrFail($request->id);
        if ($baocao != null) {
            if (Auth::user()->id === $baocao->user_id) {
                $baocao->delete();
                return response()->json([
                    'success' => 'Xóa báo cáo thành công'
                ]);
            } else {
                return response()->json([
                    'errors' => 'Bạn không có quyền xóa báo cáo này!'
                ]);
            }
        } else {
            return response()->json([
                'errors' => 'Không tìm thấy báo cáo!'
            ]);
        }
    }
    public function editBaoCao(Request $request)
    {
        $request->validate([
            'noidung' => 'required|min:40',
            'baidang_id' => 'required',
            'id' => 'required'
        ], [
            'noidung.required' => 'Nội dung báo cáo không được rỗng',
            'noidung.min' => 'Nội dung báo cáo ít nhất 40 ký tự',
            'baidang_id.required' => 'Mã bài đăng không được rỗng',
        ]);
        $baocao = BaoCao::findOrFail($request->id);
        if ($baocao != null) {
            if (Auth::user()->id === $baocao->user_id) {
                $baocao->noidung = $request->noidung;
                $baocao->save();
                return response()->json([
                    'success' => 'Sửa báo cáo thành công'
                ]);
            } else {
                return response()->json([
                    'errors' => 'Bạn không có quyền sửa báo cáo này!'
                ]);
            }
        } else {
            return response()->json([
                'errors' => 'Không tìm thấy báo cáo!'
            ]);
        }
    }
}
