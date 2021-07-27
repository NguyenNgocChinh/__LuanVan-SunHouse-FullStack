<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BaiDangResource;
use App\Http\Resources\PaginateResource;
use App\Models\BaiDang;
use Illuminate\Auth\Events\Login;
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
        //QUERY LIKE
        $columns_like = [
            'keyword',
            // 'vitri'
        ];
        foreach ($columns_like as $column) {
            if (request()->has($column)) {
                $column_in_table = $column;
                if ($this->checkTatCa($request, $column)) {
                    continue;
                }
                DB::enableQueryLog();
                if ($column == 'keyword') {
                    if ($request->keyword == null) continue;
                    $column_in_table = 'tieude,diachi';
                }
                if ($column == 'vitri') {
                    if ($request->banKinhOn == 'true' || $request->vitri == null) continue;
                    $column_in_table = 'diachi';
                }

                $column = request($column);
                // $resultFullTextSearch = BaiDang::FullTextSearch($column_in_table, $column, 'id' )->get();
                $resultFullTextSearch = BaiDang::select('id')
                    ->where('trangthai', 1)
                    ->where('choduyet', 0)
                    ->search($column, null, true,true)->with('loai')->get();
                Log::info("loop i");
                Log::info($resultFullTextSearch);
                $temp = $resultFullTextSearch->implode('id', ',');
                $resultFullTextSearch = explode(',', trim($temp));
                $baidangs = $baidangs->whereIn('id', $resultFullTextSearch);
                // ->where(['trangthai'=> 1, 'choduyet' => 0]);
                // Log::info("loop i");
                // Log::info($baidangs);
                Log::info(DB::getQueryLog());
            }
        }

        //BANKINH
        $list_baidang_bankinh = [];
        if ($request->banKinhOn == 'true') {
            Log::info("ban kinh on " . $request->banKinhOn);
            if ($request->has(['X', 'Y'])) {
                $list_baidang_bankinh = $this->getBaiDangsRound($request->Y, $request->X, $request->bankinh);
            }
            Log::info(DB::getQueryLog());
            // Log::info($list_baidang_bankinh);
            $baidangs = $baidangs->whereIn('id', $list_baidang_bankinh);
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
            }
        }

        //sort
        if (request()->has('sort')) {
            $baidangs = $baidangs->orderBy('created_at', $request->sort);
            // if($request->sort == 'desc')
            //     $baidangs = $baidangs->sortByDesc('created_at');
            // else
            //     $baidangs = $baidangs->sortByDesc('created_at')->reverse();
        }
        //sort gia
        if (request()->has('sortByGia')) {
            $baidangs = $baidangs->orderBy('gia', request('sortByGia'));
        }

        $baidangs = $baidangs->paginate($this->page_size);

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
    function sortByField($array, $field, $desc =  true)
    {
        // $newArray = array_column($array, $field);
        Log::info("array");
        Log::info($array);
        $newArray = array();
        foreach ($array as $key => $row) {
            $newArray[$key] = $row[$field];
        }
        array_multisort($newArray, $desc ? SORT_DESC : SORT_ASC, $array);
    }
}
