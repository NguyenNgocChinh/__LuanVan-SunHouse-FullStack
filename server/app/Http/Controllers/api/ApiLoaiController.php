<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Loai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiLoaiController extends Controller
{
    public function getAllLoai()
    {
        return response()->json(Loai::all());
    }

    public function editLoai(Request $request)
    {
        $request->validate([
            'ten_loai' => 'required|unique:loai|max:255',
        ], [
            'ten_loai.required' => 'Tên loại không được rỗng',
            'ten_loai.unique' => '"'. $request->ten_loai. '" đã có trong CSDL',
            'ten_loai.max' => 'Tên loại không được phép quá 255 ký tự',
        ]);
        DB::table('loai')
            ->where('id', $request->id)
            ->update(['ten_loai' => $request->ten_loai]);
        return response()->json([
            'success' => 'Sửa loại thành công'
        ]);
    }
    public function addLoai(Request $request)
    {
        $request->validate([
            'ten_loai' => 'required|unique:loai|max:255',
        ], [
            'ten_loai.required' => 'Tên loại không được rỗng',
            'ten_loai.unique' => '"'. $request->ten_loai. '" đã có trong CSDL',
            'ten_loai.max' => 'Tên loại không được phép quá 255 ký tự',
        ]);
        $id = DB::table('loai')->insertGetId([
            'ten_loai' => $request->ten_loai,
        ]);
        return response()->json([
            'id' => $id,
            'success' => 'Thêm loại thành công'
        ]);
    }
    public function deleteLoai($id)
    {
        Loai::findOrFail($id)->delete();
        return response()->json([
            'success' => 'Xóa loại thành công'
        ]);
    }
}
