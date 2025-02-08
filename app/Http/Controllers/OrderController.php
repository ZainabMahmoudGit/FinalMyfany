<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;

use App\Models\Order;
use App\Models\ServiceCategory;
use App\Models\Subservice;
use App\Models\Package;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller {
    
    public function index() {
        return Order::all();
    }

    public function show(Order $order) {
        return $order;
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'services' => 'required|array',
            'service_time' => 'required|date',
            'lat' => 'required|numeric',   
            'lng' => 'required|numeric',  
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
    
        $totalPrice = 0;
        foreach ($request->services as $serviceData) {
            $category = ServiceCategory::find($serviceData['category_id']);
            $subservice = Subservice::find($serviceData['subservice_id']);
            $package = Package::find($serviceData['package_id']);
    
            if ($category && $subservice && $package) {
                $totalPrice += $package->total_price * $serviceData['quantity']; 
            }
        }
    
        $order = Order::create([
            'user_id' => $request->user_id,
            'services' => json_encode($request->services),
            'service_time' => $request->service_time,
            'lat' => $request->lat,
            'lng' => $request->lng,
            'total_price' => $totalPrice,
        ]);
    
        return response()->json([
            'message' => 'Order created successfully',
            'order' => $order
        ], 201);
    }
    
    public function update(Request $request, Order $order) {
        $order->update($request->all());
        return response()->json([
            'message' => 'Order updated successfully',
            'order' => $order
        ]);
    }
    public function destroy(Order $order) {
        $order->delete();
        return response()->json(['message' => 'Order deleted successfully']);
    }
}
