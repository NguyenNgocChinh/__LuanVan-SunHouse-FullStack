<?php

namespace App\Http\Controllers;

use App\Http\Resources\BaiDangResource;
use App\Models\BaiDang;
use App\Models\User;
use App\Models\YeuThich;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class YeuThichController extends Controller
{
    public function getYeuThichOfUser(){
        $user = Auth::user();
        if($user != null){
            $listIDPost = $user->yeuthich;
            $temp = $listIDPost->implode('baidang_id', ',');
            $listIDPost = explode(',',$temp);
            $posts = BaiDang::whereIn('id', $listIDPost)->get();
            return response()->json(BaiDangResource::collection($posts));
        }
    }
    public function addYeuThich(Request $request){
        if(Auth::check()){
            $user = Auth::user();
            $isTonTai = YeuThich::where(['user_id' => $user->id , 'baidang_id' => $request->baidang_id])->get();
            if(count($isTonTai) > 1) return 'Đã tồn tại';
            $yeuthich = new YeuThich();
            $yeuthich->baidang_id = $request->baidang_id;
            $yeuthich->user_id = $user->id;
            $yeuthich->save();
            return response()->json([
                'success' => 'Thêm yêu thích thành công'
            ]);
        }
    }
    public function removeYeuThich(Request $request){
        if(Auth::check()){
            $user = Auth::user();
            $yeuthich = YeuThich::where(['baidang_id' => $request->baidang_id , 'user_id' => $user->id]);
            if($yeuthich != null){
                $yeuthich->delete();
            }
            return response()->json([
                'success' => 'Bỏ yêu thích thành công'
            ]);
        }
    }
}
