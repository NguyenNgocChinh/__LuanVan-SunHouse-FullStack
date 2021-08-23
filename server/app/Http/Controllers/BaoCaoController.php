<?php

namespace App\Http\Controllers;

use App\Http\Resources\BaiDangBiBaoCaoResource;
use App\Http\Resources\BaiDangDetailResource;
use App\Http\Resources\BaiDangResource;
use App\Http\Resources\UserBiBaoCaoResource;
use App\Http\Resources\UserResource;
use App\Models\BaiDang;
use App\Models\BaoCao;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BaoCaoController extends Controller
{
    public function getAllBaoCao()
    {
        return response()->json(BaoCao::all());
    }
    public function getBaoCaoWithUser()
    {
        $baocaos =  BaoCao::groupBy(['user_bibaocao', 'name', 'sdt', 'email', 'vaitro', 'trangthai'])
            ->select(['user_bibaocao', 'users.sao', 'name', 'sdt', 'vaitro', 'email', 'trangthai', DB::raw('count(*) as slbitocao')])
            ->leftJoin('users', 'users.id', '=', 'baocao.user_bibaocao')
            ->orderBy('slbitocao', 'desc')
            ->get();

        foreach ($baocaos as $baocao) {
            $baidangsId = BaoCao::select(['baidang_id','sao'])->where('user_bibaocao', $baocao->user_bibaocao)->get();
            $temp = $baidangsId->implode('baidang_id', ',');
            $baidangsId = explode(',', trim($temp));
            $baidangs = BaiDang::whereIn('id', $baidangsId)->get();

            $baocao->baidang = BaiDangBiBaoCaoResource::collection($baidangs);
        }
        return response()->json($baocaos);
    }
    public function getBaiDangBaoCaoForUser()
    {
        $user = Auth::user();
        $baocaos = $user->baocao;
        $temp = $baocaos->implode('baidang_id', ',');
        $listIDPost = explode(',', trim($temp));
        $baidangs = BaiDang::whereIn('id', $listIDPost)->get();
        for ($i = 0; $i < count($baidangs); $i++) {
            for ($j = 0; $j < count($baidangs); $j++) {
                if ($baidangs[$i]->id == $baocaos[$j]->baidang_id) {
                    $baidangs[$i]->noidungbaocao = $baocaos[$j]->noidung;
                    $baidangs[$i]->sao = $baocaos[$j]->sao;
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
            'noidung' => 'required|min:20|max:255',
            'baidang_id' => 'required',
            'user_bibaocao' => 'required',
            'sao' => 'required|numeric',
        ], [
            'noidung.required' => 'Nội dung báo cáo không được rỗng',
            'noidung.min' => 'Nội dung báo cáo ít nhất 20 ký tự',
            'noidung.max' => 'Nội dung báo cáo tối đa 255 ký tự',
            'baidang_id.required' => 'Mã bài đăng không được rỗng',
            'sao.required' => 'Số sao phải dược điền',
            'sao.numberic' => 'Sao phải là số',
        ]);
        $isTonTai = BaoCao::where(['user_id' => Auth::user()->id, 'baidang_id' => $request->baidang_id])->get();
        if (count($isTonTai) > 1) {
            return response()->json([
                'errors' => 'Bạn đã báo cáo bài đăng trước đó'
            ]);
        }
        $baocao = new BaoCao();
        $baocao->user_id = Auth::user()->id;
        $baocao->user_bibaocao = $request->user_bibaocao;
        $baocao->noidung = $request->noidung;
        $baocao->sao = $request->sao;
        $baocao->baidang_id = $request->baidang_id;
        $baocao->save();

        $userBiBaoCao = User::find($request->user_bibaocao);
        $sao = BaoCao::where('user_bibaocao', $userBiBaoCao->id)->avg('sao');
        $userBiBaoCao->sao = $sao;
        $userBiBaoCao->update();
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
            if (Auth::user()->id === $baocao->user_id || Auth::user()->vaitro === 'admin') {
                $userBiBaoCao = User::find($baocao->user_bibaocao);
                $baocao->delete();

                $sao = BaoCao::where('user_bibaocao', $userBiBaoCao->id)->avg('sao');
                if($sao > 0 && $sao < 1)
                    $sao = 0.5;
                    if($sao == 0)
                    $sao = 5;
                    $userBiBaoCao->sao = $sao;
                    $userBiBaoCao->update();

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
            'noidung' => 'required|min:20|max:255',
            'baidang_id' => 'required',
            'sao' => 'required|numeric',
        ], [
            'noidung.required' => 'Nội dung báo cáo không được rỗng',
            'noidung.min' => 'Nội dung báo cáo ít nhất 20 ký tự',
            'noidung.max' => 'Nội dung báo cáo tối đa 255 ký tự',
            'baidang_id.required' => 'Mã bài đăng không được rỗng',
            'sao.required' => 'Số sao phải dược điền',
            'sao.numberic' => 'Sao phải là số',
        ]);
        $baocao = BaoCao::findOrFail($request->id);
        if ($baocao != null) {
            if (Auth::user()->id === $baocao->user_id) {
                $baocao->noidung = $request->noidung;
                $baocao->sao = $request->sao;
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
