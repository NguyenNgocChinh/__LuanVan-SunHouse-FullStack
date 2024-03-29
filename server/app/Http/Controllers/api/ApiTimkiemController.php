<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BaiDangResource;
use App\Http\Resources\BaiDangResourceSearch;
use App\Http\Resources\PaginateResource;
use App\Models\BaiDang;
use App\Models\Location;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ApiTimkiemController extends Controller
{
    public $page_size;
    public static $wrap = null;
    public function __construct(Request $request)
    {
        if ($request->page_size)
            $this->page_size = $request->page_size;
        else
            $this->page_size = BaiDang::count();
    }

    public function timkiem(Request $request)
    {
        $request->validate([
            'X' => 'numeric',
            'Y' => 'numeric'
        ]);
        Log::info($request);
        DB::enableQueryLog();
        $baidangs = new BaiDang();
        //QUERY LIKE
        $columns_like = [
            'keyword',
            // 'vitri'
        ];
        foreach ($columns_like as $column) {
            if (request()->has($column) && request($column) != null) {
                Log::info("Tìm kiếm keyword");
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
                    ->where('baidang.trangthai', 1)
                    ->where('baidang.choduyet', 0)
                    ->search($column, null, true, true)->with('users')
                    ->with('loai')->get();
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
            Log::info("Tìm kiếm lân cận");
            Log::info("ban kinh on " . $request->banKinhOn);
            if ($request->has(['X', 'Y'])) {
                $list_baidang_bankinh = $this->getBaiDangsRound($request->Y, $request->X, $request->bankinh);
            }
            $temp = $list_baidang_bankinh->implode('baidang_id', ',');
            $ids = explode(',', trim($temp));
            Log::info(DB::getQueryLog());
            $baidangs = $baidangs->whereIn('id', $ids);
            // Log::info($list_baidang_bankinh);
        }

        //QUERY WHERE column
        $columns = [
            'type', 'loai_id', 'huong'
        ];
        foreach ($columns as $column) {
            if (request()->has($column)) {

                if (request($column) == 'tatca' || request($column) == '') {
                    Log::info("search passed " . $column);
                    continue;
                }
                Log::info("search in " . $column);
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
        // QUERY DATE
        $column_date = [
            'created_at'
        ];
        foreach ($column_date as $column) {
            if (request()->has($column . "1") || request()->has($column . "2")) {
                Log::info("in created_at search");
                $column1 = date('Y-m-d 00:00:00', strtotime($request->get($column . 1)));
                $column2 = date('Y-m-d 23:59:59', strtotime($request->get($column . 2)));
                if (is_null($request->get($column . 1)) && !is_null($request->get($column . 2))) {
                    Log::info("NULL IS COLUMN1");
                    $baidangs = $baidangs->where($column, '<=', $column2);
                } else if (!is_null($request->get($column . 1)) && is_null($request->get($column . 2))) {
                    Log::info("NULL IS COLUMN 2");
                    $baidangs = $baidangs->where($column, '>=', $column1);
                } else {
                    Log::info("CA 2 DEU NOT NULL");
                    $baidangs = $baidangs->whereBetween($column, [$column1, $column2]);
                }
            }
            Log::info(DB::getQueryLog());
        }
        // QUERY BETWEEN
        $columns_between = [
            'gia', 'dientich'
        ];
        foreach ($columns_between as $column) {
            if (request()->has($column . "1") || request()->has($column . "2")) {
                $max = BaiDang::max($column);
                $column1 = request($column . "1");
                $column2 = request($column . "2");
                if (is_null($column1)) $column1 = 0;
                if (is_null($column2) || $column2 >= $max) {
                    $baidangs = $baidangs->where($column, '>=', $column1);
                } else {
                    $baidangs = $baidangs->whereBetween($column, [$column1, $column2]);
                }
                Log::info("count after " . $baidangs->count());
                Log::info(DB::getQueryLog());
            }
        }
        //QUERY Operator
        $columns_operator = [
            'sophongngu', 'sophongtam'
        ];
        foreach ($columns_operator as $column) {
            if (request()->has($column)) {

                if (request($column) == 'tatca') {
                    continue;
                }
                Log::info("search " . $column);
                $baidangs = $baidangs->where($column, '>=', $request->get($column));
            }
        }

        //sort
        if (request()->has('sort')) {
            Log::info("sort ngày đăng");
            $baidangs = $baidangs->orderBy('created_at', $request->sort);
        }
        //sort gia
        if (request()->has('sortByGia')) {
            Log::info("sort giá");
            $baidangs = $baidangs->orderBy('gia', request('sortByGia'));
        }
        $baidangs = $baidangs->where(['baidang.trangthai' => 1, 'baidang.choduyet' => 0]);
        $baidangs = $baidangs->paginate($this->page_size);

        $resultPage =  new PaginateResource($baidangs);
        $result = BaiDangResourceSearch::collection($baidangs);
        if ($request->banKinhOn == 'true') {
            $result = json_encode($result);
            $result = json_decode($result);
            usort($result, function ($a, $b) { //Sort the array using a user defined function
                return $a->bankinh < $b->bankinh ? -1 : 1; //Compare the scores
            });
        }
        return response()->json((object) [
            'page' => $resultPage,
            'baidangs' => $result
        ]);
    }

    // Search Ban Kinh
    function getBaiDangsRound($x, $y, $radius)
    {
        $radius = $radius * 1609.344;
        $kq = DB::table('location')->select('baidang_id')
            // selectRaw("baidang_id,ST_Distance_Sphere((position),(ST_GeomFromText('point($x $y)',4326))) / 1609.344 as bankinh")
            ->whereRaw("ST_Distance_Sphere((position),(ST_GeomFromText('point($x $y)',4326))) <= $radius")
            ->where('trangthai', 1)
            ->get();
        // $temp = $kq->implode('baidang_id', ',');
        // $kq = explode(',', trim($temp));
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
        $newArray = array();
        foreach ($array as $key => $row) {
            $newArray[$key] = $row[$field];
        }
        array_multisort($newArray, $desc ? SORT_DESC : SORT_ASC, $array);
    }
}
