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
        DB::table('tiennghi')
            ->where('id', $request->id)
            ->update(['ten_tiennghi' => $request->ten_tiennghi]);
        return response()->json([
            'success' => 'Sửa tiện nghi thành công'
        ]);
    }
}
