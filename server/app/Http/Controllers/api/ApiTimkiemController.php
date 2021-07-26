<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BaiDangDetailResource;
use App\Http\Resources\BaiDangResource;
use App\Http\Resources\PaginateResource;
use App\Models\BaiDang;
use App\Models\QuanHuyen;
use App\Models\ThanhPho;
use App\Models\XaPhuong;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ApiTimkiemController extends Controller
{
    public $page_size;

    public function __construct(Request $request)
    {

        if ($request->page_size)
            $this->page_size = $request->page_size;
        else
            $this->page_size = BaiDang::count();
    }

    public function timkiem(Request $request)
    {
        Log::info($request);
        DB::enableQueryLog();
        $baidangs = new BaiDang();
        $queries = [];
        //BANKINH
        $list_baidang_bankinh = [];
        if ($request->banKinhOn == 'true') {
            Log::info("ban kinh on " . $request->banKinhOn);
            if ($request->has(['X', 'Y'])) {
                $list_baidang_bankinh = $this->getBaiDangsRound($request->Y, $request->X, $request->bankinh);
            }
            Log::info(DB::getQueryLog());
            Log::info($list_baidang_bankinh);
            $baidangs = BaiDang::whereIn('baidang.id', $list_baidang_bankinh);
            $queries['bankinh'] = request('bankinh');
            $queries['banKinhOn'] = request('banKinhOn');
            $queries['banKinhWith'] = request('banKinhWith');
        }
        //QUERY WHERE column
        $columns = [
            'type', 'loai_id', 'huong'
        ];
        foreach ($columns as $column) {
            if (request()->has($column)) {
                if (request($column) == 'tatca' || request($column) == '') {
                    continue;
                }
                if ($column == 'type') {
                    if (request($column) == 'thue')
                        $result_request = 1;
                    else
                        $result_request = 0;

                    $baidangs = $baidangs->where('isChoThue', $result_request);
                } else {
                    $baidangs = $baidangs->where($column, request($column));
                }
                $queries[$column] = request($column);
            }
        }

        function checkTatCa(Request $request, $column)
        {
            $flagTatCa = false;
            if (is_array(request($column))) {
                foreach (request($column) as $item) {
                    if ($item == 'tatca') {
                        return $flagTatCa = true;
                    }
                }
            }
            return false;
        }

        //QUERY LIKE
        $vitri = '';
        $columns_like = [
            'keyword', 'vitri'
        ];
        foreach ($columns_like as $column) {
            if (request()->has($column)) {
                $column_in_table = $column;
                if (checkTatCa($request, $column)) {
                    continue;
                }

                DB::enableQueryLog();
                if ($column == 'keyword') $column_in_table = 'tieude';
                if ($column == 'vitri') {
                    Log::info("in vi tri");
                    $column_in_table = 'baidang.diachi';
                    if ($request->vitri != null) {

                        $thanhpho = count($request->vitri) >= 1 ? $request->vitri[count($request->vitri) - 1] : "";
                        $quanhuyen = count($request->vitri) >= 2 ? $request->vitri[count($request->vitri) - 2] : "";
                        $xa = count($request->vitri) == 3 ? $request->vitri[count($request->vitri) - 3] : "";
                        Log::info("detail dia chi");
                        $vitri = "$xa, $quanhuyen, $thanhpho";
                        Log::info($vitri);
                        // if ($thanhpho != '' || $quanhuyen != '' || $xa != '') {
                        // } else {
                        //     $vitri = $request->vitri[0];
                        // }
                        $request->merge([
                            'vitri' => $vitri,
                        ]);
                    }
                }

                $column = request($column);
                $column = "%" . $column . "%";
                $baidangs = $baidangs->where($column_in_table, 'like', $column);
                $queries[$column] = request($column);
                Log::info(DB::getQueryLog());
            }
        }

        // QUERY BETWEEN
        $columns_between = [
            'gia', 'dientich'
        ];

        foreach ($columns_between as $column) {
            if (request()->has($column . "1") && request()->has($column . "2")) {
                $column1 = request($column . "1");
                $column2 = request($column . "2");
                if (is_null($column1)) $column1 = 0;
                if (is_null($column2)) {
                    if ($column == 'gia') $column2 = BaiDang::max('gia');
                    if ($column == 'dientich') $column2 = BaiDang::max('dientich');
                }
                $baidangs = $baidangs->whereBetween($column, [$column1, $column2]);
                $queries[$column1] = request($column1);
                $queries[$column2] = request($column2);
            }
        }

        //QUERY Operator
        $columns_operator = [
            'sophongngu', 'sophongtam'
        ];
        foreach ($columns_operator as $column) {
            if (request()->has($column)) {
                if (request($column) == 'tatca') continue;
                $baidangs = $baidangs->where($column, '>=', $column);
                $queries[$column] = request($column);
            }
        }

        //sort
        if (request()->has('sort')) {
            $baidangs = $baidangs->orderBy('created_at', request('sort'));
            $queries['sort'] = request('sort');
        }
        //sort gia
        if (request()->has('sortByGia')) {
            $baidangs = $baidangs->orderBy('gia', request('sortByGia'));
            $queries['sortByGia'] = request('sortByGia');
        }


        $baidangs = $baidangs->paginate($this->page_size)->appends($queries);


        return response()->json((object) [
            'page' => new PaginateResource($baidangs),
            'baidangs' => BaiDangResource::collection($baidangs)
        ]);
    }

    // Search Ban Kinh
    function getBaiDangsRound($x, $y, $radius)
    {
        $radius = $radius * 1609.344;
        $kq = DB::table('location')
            ->select('baidang_id')
            ->whereRaw("ST_Distance_Sphere((position),(ST_GeomFromText('point($x $y)',4326))) <= $radius")
            ->where('trangthai', 1)
            ->get();
        $temp = $kq->implode('baidang_id', ',');
        $kq = explode(',', trim($temp));
        return $kq;
        //    return DB::select("
        //    select baidang_id from location
        //    WHERE ST_Distance_Sphere((position),
        //    (ST_GeomFromText('point($x $y)',4326))) <= $radius and trangthai = 1");
    }

    ///BAN KINH
    function distance($lat1, $lon1, $lat2, $lon2, $unit)
    {
        $radlat1 = M_PI * $lat1 / 180;
        $radlat2 = M_PI * $lat2 / 180;
        $theta = $lon1 - $lon2;
        $radtheta = M_PI * $theta / 180;
        $dist = sin($radlat1) * sin($radlat2) + cos($radlat1) * cos($radlat2) * cos($radtheta);
        if ($dist > 1) {
            $dist = 1;
        }
        $dist = acos($dist);
        $dist = $dist * 180 / M_PI;
        $dist = $dist * 60 * 1.1515;
        if ($unit == "K") {
            $dist = $dist * 1.609344;
        }
        if ($unit == "N") {
            $dist = $dist * 0.8684;
        }
        return $dist;
    }
}
