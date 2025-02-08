<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller {
    public function index() {
        return Package::all();
    }
    public function store(Request $request) {
        return Package::create($request->all());
    }
    public function show(Package $package) {
        return $package;
    }
    public function update(Request $request, Package $package) {
        $package->update($request->all());
        return $package;
    }
    public function destroy(Package $package) {
        $package->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}