<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BaiDangDetailResource;
use App\Http\Resources\BaiDangResource;
use App\Http\Resources\PaginateResource;
use App\Models\BaiDang;
use App\Models\User;
use Illuminate\Http\Request;

class ApiBaiDangController extends Controller
{
    public $page_size ;

    public function __construct(Request $request)
    {
        $this->page_size = BaiDang::count();
        if ($request->page_size)
            $this->page_size = $request->page_size;
    }

    public function getAllPosts(Request $request)
    {
        $posts = BaiDang::paginate($this->page_size);
        return response()->json([
            'pages' => new PaginateResource($posts),
            'baidangs' => BaiDangResource::collection($posts),
        ]);
    }

    public function getHotPosts()
    {
        $hot_posts = BaiDang::latest()->paginate($this->page_size);
        return response()->json([
            'pages' => new PaginateResource($hot_posts),
            'baidangs' => BaiDangResource::collection($hot_posts),
        ]);
    }

    public function getRaoBanPosts()
    {
        $raoban_posts = BaiDang::where('isChoThue', 0)->orderBy('created_at', 'desc')->paginate($this->page_size);

        return response()->json([
            'pages' => new PaginateResource($raoban_posts),
            'baidangs' => BaiDangResource::collection($raoban_posts),
        ]);
    }

    public function getChoThuePosts()
    {
        $chothue_posts = BaiDang::where('isChoThue', 1)->orderBy('created_at', 'desc')->paginate($this->page_size);
        return response()->json([
            'pages' => new PaginateResource($chothue_posts),
           'baidangs' => BaiDangResource::collection($chothue_posts),
        ]);
    }

    public function getDetailPost($id)
    {
        return response()->json(
           new BaiDangDetailResource(BaiDang::find($id))
        );
    }
}
