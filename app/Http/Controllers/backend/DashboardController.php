<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {
        return view('backend.admin.dashboard.index');
    }

    public function getCities()
    {
        $cities = City::select('id', 'name')->get();

        return response()->json($cities);
    }

    public function getCity(Request $request)
    {
        $city = City::select('name','data')->where('id', $request->id)->firstOrFail();

       return response()->json($city);
    }
}
