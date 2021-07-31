<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BaiDangDetailResource;
use App\Http\Resources\BaiDangResource;
use App\Http\Resources\PaginateResource;
use App\Models\BaiDang;
use App\Models\BaiDangHinhAnh;
use App\Models\TienNghiBaiDang;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Intervention\Image\ImageManagerStatic as Image;
use App\Events\ViewPostHandler;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;

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
        // Cache::remember('posts', 60*60*24, function () {
        //     return BaiDang::lasted();
        // })
        return response()->json(
            BaiDangResource::collection(BaiDang::latest()->paginate($this->page_size))
        );
    }

    public function getHotPosts()
    {
        $hot_posts = BaiDang::where('trangthai', 1)
            ->where('choduyet', 0)
            ->orderBy('luotxem', 'desc')
            ->limit(10)
            ->get();
        return response()->json([
            'baidangs' => BaiDangResource::collection($hot_posts)
        ]);
    }

    public function getRaoBanPosts()
    {
        $raoban_posts = BaiDang::where('isChoThue', 0)
            ->where('trangthai',1)
            ->where('choduyet', 0)
            ->orderBy('created_at', 'desc')
            ->paginate($this->page_size);

        return response()->json([
            'pages' => new PaginateResource($raoban_posts),
            'baidangs' => BaiDangResource::collection($raoban_posts),
        ]);
    }

    public function getChoThuePosts()
    {
        $chothue_posts = BaiDang::where('isChoThue', 1)
            ->where('trangthai',1)
            ->where('choduyet', 0)
            ->orderBy('created_at', 'desc')
            ->paginate($this->page_size);
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
        return response()->json(BaiDang::where(['choduyet' => 1, 'trangthai' => 1])->count());
    }

    public function getDetailPost(Request $request)
    {
        $post = BaiDang::find($request->id);
        event(new ViewPostHandler($post));
        return response()->json(
            new BaiDangDetailResource($post)
        );
    }

    public function getChoDuyetPosts()
    {
        $choduyet = BaiDang::where('choduyet', 1)
            ->where('trangthai',1)
            ->orderBy('created_at', 'desc')
            ->paginate($this->page_size);
        return response()->json([
            'pages' => new PaginateResource($choduyet),
            'baidangs' => BaiDangResource::collection($choduyet),
        ]);
    }

    public function deletePost($id)
    {
        $post = BaiDang::find($id);
        $this->authorize('delete', $post);
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
        $user = Auth::user();
        if (Gate::forUser($user)->allows('duyet-bai')) {
            $post = BaiDang::find($request->id);
            $post->choduyet = $request->choduyet;
            $post->save();
            $this->toggleStatusLocationTable($post);
            return response()->json([
                'success' => 'Cập nhật thành công'
            ]);
        }
        return response()->json([
            'fail' => 'Bạn không có quyền duyệt bài'
        ]);
    }

    public function updateTrangThai(Request $request)
    {
        $user = Auth::user();
        if (Gate::forUser($user)->allows('duyet-bai')) {
            $post = BaiDang::find($request->id);
            $post->trangthai = $request->trangthai;
            $ok = $post->save();
            $this->toggleStatusLocationTable($post);
            if ($ok)
                return response()->json([
                    'success' => 'Cập nhật thành công'
                ]);
        }
        return response()->json([
            'fail' => 'Cập nhật thất bại'
        ]);
    }

    public function duyetBai(Request $request)
    {
        $user = Auth::user();
        if (Gate::forUser($user)->allows('duyet-bai')) {
            $post = BaiDang::find($request->id);
            $post->choduyet = 0;
            $ok = $post->save();
            $this->toggleStatusLocationTable($post);
            if ($ok)
                return response()->json([
                    'success' => 'Duyệt thành công'
                ]);
        }
        return response()->json([
            'fail' => 'Bạn không có quyền duyệt bài!'
        ]);
    }

    public function storeBaiDang(Request $request)
    {
        if(!$this->verifyCaptcha($request))
            return response()->json(['errors' => 'Chưa xác thực Captcha']);
        $request->validate(
            [
                'tieude' => 'required',
                'loai_id' => 'required',
                'gia' => 'required',
                'hinhthuc' => 'required',
                'noidung' => 'required',
                'sophongngu' => 'required',
                'sophongtam' => 'required',
                'huong' => 'required',
                'dientich' => 'required',
                'diachi' => 'required',
                'toadoX' => 'required',
                'toadoY' => 'required',
                'g-recaptcha-response' => 'required'
            ],
            [
                'tieude.required' => 'Tiêu đề không được để trống!',
                'loai_id.required' => 'Chưa chọn loại của căn nhà!',
                'gia.required' => 'Giá không được để trống!',
                'hinhthuc.required' => 'Chưa chọn hình thức đăng tải!',
                'noidung.required' => 'Nội dung mô tả không được trống!',
                'sophongngu.required' => 'Số phòng ngủ không được để trống!',
                'sophongtam.required' => 'Số phòng tắm không được để trống!',
                'namxaydung.required' => 'Năm xây dựng không được để trống!',
                'huong.required' => 'Chưa chọn hướng nhà!',
                'dientich.required' => 'Diện tích không được để trống!',
                'diachi.required' => 'Địa chỉ nhà không được để trống!',
                'toadoX.required' => 'Xảy ra lỗi định vị hoặc địa chỉ không hợp lệ!',
                'toadoY.required' => 'Xảy ra lỗi định vị hoặc địa chỉ không hợp lệ!',
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
        /**********************************************/

        $baidang->choduyet = 1;
        /**********************************************/

        /**********************************************/
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
        $this->authorize('update', $baidang);
        if(!$this->verifyCaptcha($request))
            return response()->json(['errors' => 'Chưa xác thực Captcha']);
        $request->validate(
            [
                'tieude' => 'required',
                'loai_id' => 'required',
                'gia' => 'required',
                'hinhthuc' => 'required',
                'noidung' => 'required',
                'sophongngu' => 'required',
                'sophongtam' => 'required',
                'huong' => 'required',
                'dientich' => 'required',
                'diachi' => 'required',
                'toadoX' => 'required',
                'toadoY' => 'required',
            ],
            [
                'tieude.required' => 'Tiêu đề không được để trống!',
                'loai_id.required' => 'Chưa chọn loại của căn nhà!',
                'gia.required' => 'Giá không được để trống!',
                'hinhthuc.required' => 'Chưa chọn hình thức đăng tải!',
                'noidung.required' => 'Nội dung mô tả không được trống!',
                'sophongngu.required' => 'Số phòng ngủ không được để trống!',
                'sophongtam.required' => 'Số phòng tắm không được để trống!',
                'namxaydung.required' => 'Năm xây dựng không được để trống!',
                'huong.required' => 'Chưa chọn hướng nhà!',
                'dientich.required' => 'Diện tích không được để trống!',
                'diachi.required' => 'Địa chỉ nhà không được để trống!',
                'toadoX.required' => 'Xảy ra lỗi định vị hoặc địa chỉ không hợp lệ!',
                'toadoY.required' => 'Xảy ra lỗi định vị hoặc địa chỉ không hợp lệ!',
            ]
        );

        $data = $this->saveImage($request);
        $baidang->tieude = $request->tieude;
        $baidang->loai_id = $request->loai_id;
        $baidang->gia = $request->gia;
        $baidang->isChoThue = $request->hinhthuc;
        $baidang->noidung = $request->noidung;
        $baidang->sophongngu = $request->sophongngu;
        $baidang->sophongtam = $request->sophongtam;
        if ($request->namxaydung !== 'null')
            $baidang->namxaydung = $request->namxaydung;
        $baidang->huong = $request->huong;
        $baidang->dientich = $request->dientich;
        $baidang->diachi = $request->diachi;
        $baidang->toadoX = $request->toadoX;
        $baidang->toadoY = $request->toadoY;
        /**********************************************/
        // $baidang->user_id = Auth::user()->id;
        /**********************************************/

        $baidang->choduyet = 1;
        $kq = $baidang->update();
        if ($kq) {
            if ($request->dstiennghi) {
                if (count($baidang->tiennghiBaiDang) > 0) {
                    foreach ($baidang->tiennghiBaiDang as $tiennghi) {
                        $tiennghi->delete();
                    }
                }
                if (count($request->dstiennghi) > 0) {
                    foreach ($request->dstiennghi as $tiennghi) {
                        $tiennghi_bd = new TienNghiBaiDang();
                        $tiennghi_bd->baidang_id = $baidang->id;
                        $tiennghi_bd->tiennghi_id = $tiennghi;
                        $tiennghi_bd->save();
                    }
                }
            }
            //Kiem tra neu co send img tu request thi thuc hien xoa hinh cu di va import hinh moi
            if (count($data) > 0) {
                if (count($baidang->hinhanh) > 0) {
                    foreach ($baidang->hinhanh as $hinhanh) {
                        $file_path = '/images/upload/' . $hinhanh->filename;
                        if (File::exists($file_path))
                            File::delete($file_path);

                        foreach (BaiDangHinhAnh::all() as $h) {
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
        $this->toggleStatusLocationTable($baidang);
        return response()->json(new BaiDangDetailResource($baidang->fresh()));
    }

    function saveImage(Request $request)
    {
        $data = [];
        if ($request->hasfile('file')) {
            foreach ($request->file('file') as $file) {
                $date = new DateTime("now");
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

    public function getAllBaiDangOfUser()
    {
        $user = Auth::user();
        if ($user) {
            return json_encode(BaiDangDetailResource::collection(BaiDang::where('user_id', '=', $user->id)->get()));
        } else {
            return response()->json([
                'status' => 'faild',
                'message' => 'Lấy dữ liệu thất bại!'
            ]);
        }
    }
    public function getWaitingBaiDangOfUser()
    {
        if (Auth::check()) {
            return  json_encode(BaiDangDetailResource::collection(
                BaiDang::where('user_id', '=', Auth::id())
                    ->where('choduyet', '=', 1)
                    ->get()
            ));
        } else {
            return response()->json([
                'status' => 'faild',
                'message' => 'Lấy dữ liệu thất bại!'
            ]);
        }
    }
    private function toggleStatusLocationTable($post)
    {
        if ($post->trangthai) {
            Log::info("ss " . $post->trangthai);
            Log::info("message");
            DB::table('location')
                ->where('baidang_id', $post->id)
                ->update(['trangthai' => !$post->choduyet]); // bởi vì chưa duyệt  = 1 , đã duyệt = 0
        } else {
            DB::table('location')
                ->where('baidang_id', $post->id)
                ->update(['trangthai' => 0]);
        }
    }

    public function verifyCaptcha(Request $request)
    {
        $token = $request->get('g-recaptcha-response');
        Log::info($request);
        Log::info("token");
        Log::info($token);
        $recaptcha = new \ReCaptcha\ReCaptcha(env('INVISIBLE_RECAPTCHA_SECRETKEY'));
        $resp = $recaptcha->setExpectedHostname($request->getHost())
            // ->setExpectedAction('updateBaiDang')
            ->verify($token, $request->ip());
        if ($resp->isSuccess()) {
            // Verified!
            return true;
        } else {
            $errors = $resp->getErrorCodes();
            return false;
        }
    }
}
