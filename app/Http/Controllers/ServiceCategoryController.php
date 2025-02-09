<?php

namespace App\Http\Controllers;

use App\Models\ServiceCategory;
use Illuminate\Http\Request;


class ServiceCategoryController extends Controller {
    public function index()
    {
        try {
            $categories = ServiceCategory::with('subservices')->get();
            return response()->json($categories);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);
    
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = storage_path('app/assets/services');
    
            // إنشاء المسار لو مش موجود
            if (!file_exists($imagePath)) {
                mkdir($imagePath, 0777, true);
            }
    
            // نقل الصورة
            $image->move($imagePath, $imageName);
    
            // تخزين الرابط
            $imageUrl = url("storage/assets/services/" . $imageName);
        } else {
            $imageUrl = null;
        }
    
        $service = ServiceCategory::create([
            'name' => $request->name,
            'image' => $imageUrl,
        ]);
    
        return response()->json($service, 201);
    }
    
    
    public function show(ServiceCategory $category) {
        return $category;
    }
    public function update(Request $request, ServiceCategory $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);
    
        // تحديث الاسم
        $category->name = $request->name;
    
        // تحديث الصورة لو المستخدم رفع صورة جديدة
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = storage_path('app/assets/services');
    
            // إنشاء المسار لو مش موجود
            if (!file_exists($imagePath)) {
                mkdir($imagePath, 0777, true);
            }
    
            // حذف الصورة القديمة لو موجودة
            if ($category->image) {
                $oldImagePath = storage_path('app/assets/services/' . basename($category->image));
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
    
            // نقل الصورة الجديدة
            $image->move($imagePath, $imageName);
    
            // تخزين الرابط الجديد
            $category->image = url("storage/assets/services/" . $imageName);
        }
    
        // حفظ التعديلات
        $category->save();
    
        return response()->json($category);
    }
    
    
    public function destroy(ServiceCategory $category) {
        $category->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
    
}