<?php

namespace App\Observers;

use App\Mail\MailMatchTinDang;
use App\Models\BaiDang;
use App\Models\ThongTinDangKy;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class BaiDangObserver
{
    public $afterCommit = true;

    public function created(BaiDang $baiDang)
    {
        $this->addLocationTable($baiDang);
        // $this->notifyPostRelate($baiDang);
    }
    public function updated(BaiDang $baiDang)
    {
    }
    public function deleted(BaiDang $baiDang)
    {
        $this->removeLocationTable($baiDang);
    }

    public function restored(BaiDang $baiDang)
    {
        //
    }
    public function forceDeleted(BaiDang $baiDang)
    {
        //
    }



    // FUNCTION
    private function addLocationTable(BaiDang $baiDang)
    {
        $trangthai = 0;
        if($baiDang->trangthai && $baiDang->choduyet)
            $trangthai = 1;
        DB::statement("INSERT INTO location(baidang_id,position,trangthai)
        value($baiDang->id,ST_GeomFromText('point($baiDang->toadoX $baiDang->toadoY)',4326)), $trangthai");
    }
    private function removeLocationTable(BaiDang $baiDang){
        DB::table('location')->where('baidang_id', $baiDang->id)->delete();
    }
    //Handler Function
    private function notifyPostRelate(BaiDang $baiDang)
    {
        $collections = ThongTinDangKy::all();

        foreach ($collections as $thongtin) {
            $gia = true;
            $dientich = true;
            $loai = true;
            $sophongngu = true;
            $sophongtam = true;
            $diachi = true;
            $isChoThue = true;
            $huong = true;
            $user = $thongtin->user;
            if ($user->id != $baiDang->user->id) {
                if ($thongtin->giamin && $thongtin->giamax) {
                    $gia = $this->searchBetweenCollection($baiDang, 'gia', $thongtin->giamin, $thongtin->giamax);
                }
                if ($thongtin->dientichmin && $thongtin->dientichmax) {
                    $dientich = $this->searchBetweenCollection($baiDang, 'dientich', $thongtin->dientichmin, $thongtin->dientichmax);
                }
                if ($thongtin->loai) {
                    $loai = $this->searchEqual($baiDang, 'loai_id', $thongtin->loai_id);
                }
                if ($thongtin->sophongngu) {
                    $sophongngu = $this->searchRank($baiDang, 'sophongtam', $thongtin->sophongngu);
                }
                if ($thongtin->sophongtam) {
                    $sophongtam = $this->searchRank($baiDang, 'sophongtam', $thongtin->sophongtam);
                }
                if ($thongtin->isChoThue) {
                    $isChoThue = $this->searchEqual($baiDang, 'isChoThue', $thongtin->isChoThue);
                }
                if ($thongtin->diachi) {
                    $diachi = $this->searchLikeCollection($baiDang, 'diachi', $thongtin->diachi);
                }
                if ($thongtin->huong) {
                    $huong = $this->searchEqual($baiDang, 'huong', $thongtin->huong);
                }
                if ($gia && $loai && $sophongngu && $dientich && $sophongtam && $diachi && $isChoThue && $huong) {

                    Mail::to($user->email)->send(new MailMatchTinDang($user, $baiDang));
                }
            }
        }
    }
    //Search Function
    private function searchLikeCollection($collection, $field, $keyword)
    {
        return false !== stristr($collection->$field, $keyword);
    }

    private function searchBetweenCollection($collection, $field, $value1, $value2)
    {
        return $collection->$field >= $value1 && $collection->$field <= $value2;
    }

    private function searchRank($collection, $field, $value, $higher = true)
    {
        if ($higher)
            return $collection->$field >= $value;
        return $collection->$field <= $value;
    }

    private function searchEqual($collection, $field, $value)
    {
        return $collection->$field == $value;
    }

}
