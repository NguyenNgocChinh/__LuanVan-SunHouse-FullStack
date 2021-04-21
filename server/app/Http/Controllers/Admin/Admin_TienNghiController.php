<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TienNghi;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Admin_TienNghiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('admin.tiennghi', ['tiennghis' => TienNghi::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $tiennghi = new TienNghi();
        $tiennghi->ten_tiennghi = $request->ten_tiennghi;
        $kq = $tiennghi->save();
        return $kq;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $tiennghi = TienNghi::find($id);
        $tiennghi->ten_tiennghi = $request->ten_tiennghi;
        $kq = $tiennghi->update();
        return $kq;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        if (TienNghi::find($id)->delete())
            return true;
        return false;
    }
}
