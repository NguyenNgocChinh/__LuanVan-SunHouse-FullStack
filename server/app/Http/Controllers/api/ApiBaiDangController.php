<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BaiDangDetailResource;
use App\Http\Resources\BaiDangResource;
use App\Http\Resources\PaginateResource;
use App\Models\BaiDang;
use App\Models\BaiDangHinhAnh;
use App\Models\TienNghiBaiDang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Intervention\Image\ImageManagerStatic as Image;

class ApiBaiDangController extends Controller
{
    public $page_size;

    public function __construct(Request $request)
    {
        $this->page_size = BaiDang::count();
        if ($request->page_size)
            $this->page_size = $request->page_size;
    }

    public function getAllPosts()
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

    public function countPosts()
    {
        return response()->json(BaiDang::count());
    }

    public function countChoDuyetPosts()
    {
        return response()->json(BaiDang::where('choduyet', 1)->count());
    }

    public function getDetailPost($id)
    {

        return response()->json(
            new BaiDangDetailResource(BaiDang::find($id))
        );
    }

    public function getChoDuyetPosts()
    {
        $choduyet = BaiDang::where('choduyet', 1)->orderBy('created_at', 'desc')->paginate($this->page_size);
        return response()->json([
            'pages' => new PaginateResource($choduyet),
            'baidangs' => BaiDangResource::collection($choduyet),
        ]);
    }

    public function deletePost($id)
    {
        $post = BaiDang::find($id);
        if ($post) {
            $post->delete();
            return response()->json([
                'success' => 'Xóa thành công'
            ]);
        }
        return response()->json([
            'fail' => 'Xóa thất bại'
        ]);
    }

    public function updateDuyetBai(Request $request)
    {
        $post = BaiDang::find($request->id);
        $post->choduyet = $request->choduyet;
        $ok = $post->save();
        if ($ok)
            return response()->json([
                'success' => 'Cập nhật thành công'
            ]);
        return response()->json([
            'fail' => 'Cập nhật thất bại'
        ]);
    }

    public function updateTrangThai(Request $request)
    {
        $post = BaiDang::find($request->id);
        $post->trangthai = $request->trangthai;
        $ok = $post->save();
        if ($ok)
            return response()->json([
                'success' => 'Cập nhật thành công'
            ]);
        return response()->json([
            'fail' => 'Cập nhật thất bại'
        ]);
    }

    public function duyetBai(Request $request)
    {

        $post = BaiDang::find($request->id);
        $post->choduyet = 0;
        $ok = $post->save();
        if ($ok)
            return response()->json([
                'success' => 'Duyệt thành công'
            ]);
        return response()->json([
            'fail' => 'Duyệt thất bại'
        ]);
    }

    public function storeBaiDang(Request $request)
    {

        $request->validate(
            [
                'tieude' => 'required',
                'loai_id' => 'required',
                'gia' => 'required',
                'hinhthuc' => 'required',
                'noidung' => 'required',
                'sophongngu' => 'required',
                'sophongtam' => 'required',
                'namxaydung' => 'required',
                'huong' => 'required',
                'dientich' => 'required',
                'diachi' => 'required',
                'toadoX' => 'required',
                'toadoY' => 'required',
            ]
        );

        $baidang = new BaiDang();
        $baidang->tieude = $request->tieude;
        $baidang->loai_id = $request->loai_id;
        $baidang->gia = $request->gia;
        $baidang->isChoThue = $request->hinhthuc;
        $baidang->noidung = $request->noidung;
        $baidang->sophongngu = $request->sophongngu;
        $baidang->sophongtam = $request->sophongtam;
        $baidang->namxaydung = $request->namxaydung;
        $baidang->huong = $request->huong;
        $baidang->dientich = $request->dientich;
        $baidang->diachi = $request->diachi;
        $baidang->toadoX = $request->toadoX;
        $baidang->toadoY = $request->toadoY;
        /**********************************************/
        $baidang->user_id = Auth::user()->id;
        $baidang->id_goi = 1;
        /**********************************************/

        $baidang->choduyet = 1;
        $kq = $baidang->save();

        if ($kq) {
            if (is_array($request->dstiennghi)) {
                foreach ($request->dstiennghi as $tiennghi) {
                    $tiennghi_bd = new TienNghiBaiDang();
                    $tiennghi_bd->baidang_id = $baidang->id;
                    $tiennghi_bd->tiennghi_id = $tiennghi;
                    $tiennghi_bd->save();
                }
            }

            $data = $this->saveImage($request);

            if (count($data) > 0) {
                foreach ($data as $hinhanh) {
                    $hinhanh_new = new BaiDangHinhAnh();
                    $hinhanh_new->baidang_id = $baidang->id;
                    $hinhanh_new->filename = $hinhanh;
                    $hinhanh_new->save();
                }
            }
        }
        return response()->json(new BaiDangDetailResource($baidang));
    }

    public function updateBaiDang(Request $request)
    {

        $baidang = BaiDang::find($request->id);
        $data = $this->saveImage($request);
        $baidang->tieude = $request->tieude;
        $baidang->loai_id = $request->loai_id;
        $baidang->gia = $request->gia;
        $baidang->isChoThue = $request->hinhthuc;
        $baidang->noidung = $request->noidung;
        $baidang->sophongngu = $request->sophongngu;
        $baidang->sophongtam = $request->sophongtam;
        $baidang->namxaydung = $request->namxaydung;
        $baidang->huong = $request->huong;
        $baidang->dientich = $request->dientich;
        $baidang->diachi = $request->diachi;
        /**********************************************/
        $baidang->id_goi = 1;
        /**********************************************/

        $baidang->toadoX = $request->toadoX;
        $baidang->toadoY = $request->toadoY;
        /**********************************************/
        $baidang->user_id = Auth::user()->id;
        /**********************************************/

        $baidang->choduyet = 1;
        $kq = $baidang->save();

        if ($kq) {
            if (count($request->dstiennghi) > 0) {
                if (count($baidang->tiennghi_baidang) > 0) {
                    foreach ($baidang->tiennghi_baidang as $tiennghi) {
                        $tiennghi->delete();
                    }
                }

                foreach ($request->dstiennghi as $tiennghi) {
                    $tiennghi_bd = new TienNghiBaiDang();
                    $tiennghi_bd->baidang_id = $baidang->id;
                    $tiennghi_bd->tiennghi_id = $tiennghi;
                    $tiennghi_bd->save();
                }
            }
            //Kiem tra neu co send img tu request thi thuc hien xoa hinh cu di va import hinh moi
            if (count($data) > 0) {
                if (count($baidang->hinhanh) > 0) {

                    foreach ($baidang->hinhanh as $hinhanh) {
                        $file_path = '/images/upload/' . $hinhanh->filename;
                        if (File::exists($file_path))
                            File::delete($file_path);

                        foreach (BaiDangHinhAnh::all() as $h){
                            if ($h->baidang_id == $baidang->id)
                                $h->delete();
                        }

                    }
                }
                foreach ($data as $hinhanh) {
                    $hinhanh_new = new BaiDangHinhAnh();
                    $hinhanh_new->baidang_id = $baidang->id;
                    $hinhanh_new->filename = $hinhanh;
                    $hinhanh_new->save();
                }
            }
        }
        return response()->json(new BaiDangDetailResource($baidang->fresh()));
    }

    function saveImage(Request $request)
    {
        $data = [];
        if ($request->hasfile('file')) {
            foreach ($request->file('file') as $file) {
                $date = new \DateTime("now");
                $name = $date->format('U') . "_";
                $name .= $file->getClientOriginalName();
                $img_resize = Image::make($file->getPathName());
                $img_resize->resize(960, 600);
                $img_resize->save(public_path('images/upload/' . $name));
                //$img_resize->move(public_path() . '/images/', $name);
                $data[] = $name;
            }
        }
        return $data;
    }
}
