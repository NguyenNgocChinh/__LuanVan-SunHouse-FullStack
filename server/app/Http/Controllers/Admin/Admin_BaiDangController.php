<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BaiDang;
use App\Models\TienNghiBaiDang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Admin_BaiDangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.baidang', ['baidangs' => BaiDang::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = [];
        if ($request->hasfile('file')) {

            foreach ($request->file('file') as $file) {
                $name = $file->getClientOriginalName();
                $file->move(public_path() . '/images/', $name);
                $data[] = $name;
            }
        }

        $baidang = new BaiDang();
        $baidang->hinhanh = implode(',', $data);
        $err="";
        $baidang->tieude = $request->tieude;
        if(str_word_count($baidang->tieude) >0){
            $err.="noi dung khong duoc de trong";
            return $err;
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

        $kq = $baidang->save();

        if($kq){
            foreach($request->dstiennghi as $tiennghi )
            {
                $tiennghi_bd = new TienNghiBaiDang();
                $tiennghi_bd->baidang_id = $baidang->id;
                $tiennghi_bd->tiennghi_id = $tiennghi;
                $tiennghi_bd->save();
            }
        }

        //return redirect()->back()->with("kq",$kq);
        return redirect()->route('baidang_show', ['baidang' => $baidang->id]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return "dsadsadadad";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (BaiDang::find($id)->delete())
            return true;
        return false;
    }
}
