<?php

namespace App\Http\Controllers;

use App\Models\Subservice;
use Illuminate\Http\Request;

class SubserviceController extends Controller {
    public function index() {
        return Subservice::all();
    }
    public function store(Request $request) {
        return Subservice::create($request->all());
    }
    public function show(Subservice $subservice) {
        return $subservice;
    }
    public function update(Request $request, Subservice $subservice) {
        $subservice->update($request->all());
        return $subservice;
    }
    public function destroy(Subservice $subservice) {
        $subservice->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}