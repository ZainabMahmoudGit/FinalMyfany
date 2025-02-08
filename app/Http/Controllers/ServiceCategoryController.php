<?php

namespace App\Http\Controllers;

use App\Models\ServiceCategory;
use Illuminate\Http\Request;


class ServiceCategoryController extends Controller {
    public function index() {
        return ServiceCategory::all();
    }
    public function store(Request $request) {
        return ServiceCategory::create($request->all());
    }
    public function show(ServiceCategory $category) {
        return $category;
    }
    public function update(Request $request, ServiceCategory $category) {
        $category->update($request->all());
        return $category;
    }
    public function destroy(ServiceCategory $category) {
        $category->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
    
}