<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BaiDangResource;
use App\Models\BaiDang;

class ApiBaiDangController extends Controller
{
    public function getAllPosts()
    {
        $all_posts = BaiDang::get()->sortBy('created_at', SORT_REGULAR, true);
        return response()->json(BaiDangResource::collection($all_posts));
    }

    public function getHotPosts()
    {
        $hot_posts = BaiDang::get()->sortBy('created_at', SORT_REGULAR, true);
        return response()->json(BaiDangResource::collection($hot_posts));
    }

    public function getRaoBanPosts()
    {
        $raoban_posts = BaiDang::where('isChoThue', '=', 0)->orderBy('created_at', 'desc')->get();
        return response()->json(BaiDangResource::collection($raoban_posts));
    }

    public function getChoThuePosts()
    {
        $chothue_posts = BaiDang::where('isChoThue', '=', 1)->orderBy('created_at', 'desc')->get();
        return response()->json(BaiDangResource::collection($chothue_posts));
    }

    public function getDetailPost($id)
    {
        return response()->json(BaiDang::findOrFail($id));
    }
}
