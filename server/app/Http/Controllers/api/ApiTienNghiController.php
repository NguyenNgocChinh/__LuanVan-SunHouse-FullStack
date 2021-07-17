<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\TienNghi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiTienNghiController extends Controller
{
    public function getAllTienNghi()
    {
        return response()->json(TienNghi::all());
    }
    public function editTienNghi(Request $request)
    {
        $request->validate([
            'ten_tiennghi' => 'required|unique:tiennghi|max:255',
        ], [
            'ten_tiennghi.required' => 'Tên tiện nghi không được rỗng',
            'ten_tiennghi.unique' => '"'. $request->ten_tiennghi. '" đã có trong CSDL',
            'ten_tiennghi.max' => 'Tên tiện nghi không được phép quá 255 ký tự',
        ]);
        DB::table('tiennghi')
            ->where('id', $request->id)
            ->update(['ten_tiennghi' => $request->ten_tiennghi]);
        return response()->json([
            'success' => 'Sửa tiện nghi thành công'
        ]);
    }
    public function addTienNghi(Request $request)
    {
        $request->validate([
            'ten_tiennghi' => 'required|unique:tiennghi|max:255',
        ], [
            'ten_tiennghi.required' => 'Tên tiện nghi không được rỗng',
            'ten_tiennghi.unique' => '"'. $request->ten_tiennghi. '" đã có trong CSDL',
            'ten_tiennghi.max' => 'Tên tiện nghi không được phép quá 255 ký tự',
        ]);
        $id = DB::table('tiennghi')->insertGetId([
            'ten_tiennghi' => $request->ten_tiennghi,
        ]);
        return response()->json([
            'id' => $id,
            'success' => 'Thêm tiện nghi thành công'
        ]);
    }
    public function deleteTienNghi($id)
    {
        TienNghi::findOrFail($id)->delete();
        return response()->json([
            'success' => 'Xóa tiện nghi thành công'
        ]);
    }
}
