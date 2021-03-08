<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Goi;
use App\Models\Loai;
use Illuminate\Http\Request;

class Admin_GoiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.goi', ['gois' => Goi::all()]);
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
        $goi = new Goi();
        $goi->ten = $request->ten;
        $goi->gia = $request->gia;
        $goi->slbaidang = $request->slbaidang;
        $goi->hansudung = $request->hansudung;
        $goi->douutien = $request->douutien;
        $kq = $goi->save();
        return $kq;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $goi = Goi::find($id);
        $goi->ten = $request->ten;
        $goi->gia = $request->gia;
        $goi->slbaidang = $request->slbaidang;
        $goi->hansudung = $request->hansudung;
        $goi->douutien = $request->douutien;
        $kq = $goi->save();
        return $kq;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Goi::find($id)->delete())
            return true;
        return false;
    }
}