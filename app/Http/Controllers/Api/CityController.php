<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\City;
use App\Models\User;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function getCity(Request $request)
    {
        $user = User::select('id')->where('name', $request->name)->first();

        if($user)
        {
            $city = City::select('name', 'data')->where('user_id', $user->id)->firstOrFail();
            return response()->json($city);
        }
        else
        {
            $returnData = [
                'status' => 'error',
                'message' => 'no data'
            ];

            return response()->json($returnData, 500);
        }
    }
}
