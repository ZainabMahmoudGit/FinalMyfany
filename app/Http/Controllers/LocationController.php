<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Country;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function getCountries()
    {
        return response()->json(Country::all());
    }

    public function getAreas($countryId)
    {
        $areas = Area::where('country_id', $countryId)->get();
        return response()->json($areas);
    }

    public function getAreaDetails($id)
    {
        $area = Area::findOrFail($id);
        return response()->json($area);
    }
}


