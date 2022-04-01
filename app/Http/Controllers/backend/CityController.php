<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        return view('backend.admin.cities.index');
    }

    public function store(Request $request)
    {
        if(City::where('name', $request->name)->exists())
        {
            return response()->json(404);
        }
        else
        {
            $city = City::create([
                'name' => $request->name,
                'data' => $request->data
            ]);

            return response()->json($city);
        }
    }

    public function destroy($id)
    {
        City::where('id', $id)->delete();

       return response()->json();
    }
}
