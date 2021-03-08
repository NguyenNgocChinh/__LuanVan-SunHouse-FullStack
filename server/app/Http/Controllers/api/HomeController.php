<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index()
    {
        return DB::select('CALL popup_bando()');
    }

}
