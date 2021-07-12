<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Loai;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Admin_LoaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('admin.loai', ['loais' => Loai::All()]);
        //
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
     * return $request;
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $loai = new Loai();
        $loai->ten_loai = $request->tenloai;
        $kq = $loai->save();
        return $kq;
        //return redirect()->back();
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
        $loai = Loai::find($id);
        $loai->ten_loai = $request->tenloai;
        $kq = $loai->update();
        return $kq;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Request $request)
    {
        if (Loai::find($request->id)->delete())
            return true;
        return false;
    }
}
