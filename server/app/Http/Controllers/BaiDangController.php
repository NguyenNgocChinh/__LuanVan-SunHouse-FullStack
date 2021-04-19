<?php

namespace App\Http\Controllers;

use App\Models\BaiDang;
use App\Models\BaiDangHinhAnh;
use App\Models\BinhLuan;
use App\Models\Loai;
use App\Models\TienNghi;
use App\Models\TienNghiBaiDang;
use App\Models\User;
use DateTime;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Intervention\Image\ImageManagerStatic as Image;

class BaiDangController extends Controller
{

    public function __construct()
    {
//        $this->middleware('auth')->except('show'); //only('store', 'update','create','destro');
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

    /**
     * Display a listing of the resource.
     *
     * @return RedirectResponse
     */

    public
    function index()
    {
        return redirect()->route('timkiem_baidang');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|Response
     */
    public
    function create()
    {
        $loais = Loai::all();
        $tn = TienNghi::all();
        return view('nguoidung.guitaisan', [
            'loais' => $loais,
            'tiennghis' => $tn,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */


    public
    function store(Request $request)
    {
        $data = $this->saveImage($request);
        $baidang = new BaiDang();
        $baidang->tieude = $request->tieude;
        $baidang->loai_id = $request->loai;
        $baidang->gia = $request->gia;
        $baidang->isChoThue = $request->hinhthuc;
        $baidang->noidung = $request->noidung;
        $baidang->sophongngu = $request->phongngu;
        $baidang->sophongtam = $request->phongtam;
        $baidang->namxaydung = $request->namxaydung;
        $baidang->huong = $request->huong;
        $baidang->dientich = $request->dientich;
        $baidang->diachi = $request->diachi;
        $baidang->toadoX = $request->toadoX;
        $baidang->toadoY = $request->toadoY;

        $baidang->user_id = Auth::user()->id;

        $goi = Auth::user()->goi;
        $baidang->id_goi = $goi[0]->goi_id;
        $baidang->ngayhethan = $goi[0]->ngayhethan;

        $baidang->choduyet = 0;
        $kq = $baidang->save();

        if ($kq) {
            foreach ($request->dstiennghi as $tiennghi) {
                $tiennghi_bd = new TienNghiBaiDang();
                $tiennghi_bd->baidang_id = $baidang->id;
                $tiennghi_bd->tiennghi_id = $tiennghi;
                $tiennghi_bd->save();
            }
            if (count($data) > 0) {
                foreach ($data as $hinhanh) {
                    $hinhanh_new = new BaiDangHinhAnh();
                    $hinhanh_new->baidang_id = $baidang->id;
                    $hinhanh_new->filename = $hinhanh;
                }
            }
        }
        return redirect()->route('baidang_show', ['baidang' => $baidang->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View|Response
     */
    public
    function show($id)
    {
        $baidang = BaiDang::select('*')->where('id', $id)->get();
        $binhluan = BinhLuan::join('users', 'users.id', '=', 'user_id')->where('binhluan.baidang_id', '=', $id)->get();
        $user = BaiDang::find($id);
        $user = User::find($user->user_id);
        $tiennghi = TienNghiBaiDang::select('ten_tiennghi')->join('tiennghi', 'tiennghi.id', '=', 'tiennghi_id')->where('baidang_id', '=', $id)->get();

        $baidangs = new BaiDang();
        $baidangs_new = $baidangs->show_new_post();
        return view(
            'nguoidung.chitietSP',
            [
                'baidangs' => $baidang,
                'binhluans' => $binhluan,
                'user' => $user,
                'baidangs_new' => $baidangs_new,
                'tiennghis' => $tiennghi,
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View|Response
     */
    public
    function edit($id)
    {
        $arr_TienNghi = TienNghiBaiDang::select('tiennghi_id')->where('baidang_id', '=', $id)->get();
        return view(
            'nguoidung.suataisan',
            [
                'baidang' => BaiDang::find($id),
                'loais' => Loai::all(),
                'tiennghis' => TienNghi::all(),
                'tiennghiofbaidang' => $arr_TienNghi
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public
    function update(Request $request, $id)
    {
        $baidang = BaiDang::find($id);
        $data = $this->saveImage($request);
        $err = "";
        $baidang->tieude = $request->tieude;
        if ($baidang->tieude == null) {
            $err .= "noi dung khong duoc de trong";
            return Redirect::back()->withErrors([$err]);
        }
        $baidang->loai_id = $request->loai;
        $baidang->gia = $request->gia;
        $baidang->isChoThue = $request->hinhthuc;
        $baidang->noidung = $request->noidung;
        $baidang->sophongngu = $request->phongngu;
        $baidang->sophongtam = $request->phongtam;
        $baidang->namxaydung = $request->namxaydung;
        $baidang->huong = $request->huong;
        $baidang->dientich = $request->dientich;
        $baidang->diachi = $request->diachi;
        $baidang->id_goi = 1;
        $baidang->toadoX = $request->toadoX;
        $baidang->toadoY = $request->toadoY;
        $baidang->user_id = Auth::user()->id;
        $baidang->choduyet = 0;
        $kq = $baidang->update();

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
                        $hinhanh->delete();
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
        return redirect()->route('baidang_show', ['baidang' => $baidang->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public
    function destroy($id)
    {
        $baidang = BaiDang::find($id);
        $baidang->delete();
    }
}
