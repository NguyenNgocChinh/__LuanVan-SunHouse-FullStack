<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaginateResource;
use App\Models\Goi;
use Illuminate\Http\Request;

class ApiGoiController extends Controller
{


    public function getAllPackages(Request $request)
    {
        return response()->json(Goi::all());
    }
}
