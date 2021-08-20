<?php

namespace App\Http\Controllers;

use App\Http\Resources\DanhGiaResource;
use App\Models\DanhGia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DanhGiaController extends Controller
{
    public function getAllDanhGia(){
        if(Auth::check()){
            if(Auth::user()->vaitro == 'admin')
                return response()->json(DanhGiaResource::collection(DanhGia::latest()->get()));
                return response()->json([
                    'errors' => 'Bạn không đủ quyền'
                ]);
        }
        return response()->json([
            'errors' => 'Bạn cần phải đăng nhập'
        ]);
    }
    public function getDanhGiaForUser(){
        if(Auth::check()){
            return response()->json(Auth::user()->danhgia);
        }
        return response()->json([
            'errors' => 'Bạn cần phải đăng nhập'
        ]);
    }
    public function danhGiaUser(Request $request){
        $request->validate([
            'sao' => 'required',
            'noidung' => 'required|min:4',
            'user_id' => 'required',
        ],[
            'sao.required' => 'Số sao phải được chỉ định',
            'noidung.required' => 'Nội dung đánh giá phải được nhập vào',
            'user_id.required' => 'Phải chọn user để đánh giá.'
        ]);
        $user = User::findOrFail($request->user_id);
        $danhgia =  DanhGia::create($request->only(['sao', 'user_id', 'noidung']));
        $user->sao = $request->sao;
        $user->save();
        return response()->json(
            new DanhGiaResource($danhgia)
        );
    }
    public function editDanhGia(Request $request){
        $request->validate([
            'sao' => 'required',
            'noidung' => 'required|min:4',
        ],[
            'sao.required' => 'Số sao phải được chỉ định',
            'noidung.required' => 'Nội dung đánh giá phải được nhập vào',
        ]);
        $user = User::findOrFail($request->user_id);
        $danhgia = DanhGia::findOrFail($request->id);
        $danhgia->fill($request->only(['sao', 'noidung']));
        $danhgia->save();
        $user->sao = $request->sao;
        $user->save();
        return response()->json([
            'success' => 'Chỉnh sửa đánh giá thành công',
            'danhgia' => $danhgia,
        ]);
    }
    public function removeDanhGia($idDanhGia){
        $danhgia = DanhGia::findOrFail($idDanhGia);
        $user = User::findOrFail($danhgia->user_id);
        $danhgia->delete();
        $minSao = DanhGia::select(DB::raw('min(sao) as minSao'))->where('user_id',$danhgia->user_id)->get();
        Log::info($minSao);
        $user->sao = 5;
        if($minSao[0]->minSao != null)
        $user->sao = $minSao[0]->minSao;

        $user->save();
        return response()->json([
            'success' => 'Xóa đánh giá thành công'
        ]);
    }

}
