<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaginateResource;
use App\Models\Goi;
use Illuminate\Http\Request;

class ApiGoiController extends Controller
{


    public function getAllPackages(Request $request)
    {
        return response()->json(Goi::all());
    }
    public function countPackages(){
        return response()->json(Goi::count());
    }
    public function getPackage($id){
        return response()->json(Goi::find($id));
    }
    public function storePackage(Request $request){
        $request->validate([
           'ten' => 'required',
           'gia' => 'required|numeric',
           'douutien' => 'required|numeric',
           'slbaidang' => 'required|numeric',
           'hansudung' => 'required|numeric',
        ]);

        $goi = new Goi();
        $goi->fill($request->all());
        $goi->save();
        return response()->json($goi);
    }

    public function updatePackage(Request $request){
        $request->validate([
            'ten' => 'required',
            'gia' => 'required|numeric',
            'douutien' => 'required|numeric',
            'slbaidang' => 'required|numeric',
            'hansudung' => 'required|numeric',
        ]);
        $goi = Goi::find($request->id);
        $goi->fill($request->all());
        $goi->save();
        return response()->json($goi);
    }

    public function deletePackage($id){
        $goi = Goi::find($id);
        if ($goi)
        {
            $goi->delete();
            return response()->json(
                [
                    'success' => "Xóa thành công"
                ]
            );
        }
        return response()->json(
            [
                'error' => "Xóa thất bại"
            ]
        );
    }

}
