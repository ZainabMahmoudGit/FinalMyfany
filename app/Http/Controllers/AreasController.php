<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;

class AreasController extends Controller
{
    public function store()
    {
        $areas = [
            ['name' => 'حولي', 'country_id' => 1],
            ['name' => 'السالمية', 'country_id' => 1],
            ['name' => 'الفروانية', 'country_id' => 1],
        ];

        foreach ($areas as $area) {
            Area::create($area);
        }

        return response()->json(['message' => 'تمت إضافة المناطق بنجاح'], 201);
    }
}

