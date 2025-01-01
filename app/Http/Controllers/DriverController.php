<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use App\Models\Driver;
use Twilio\Rest\Client;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function sendOtp(Request $request)
{
    $request->validate([
        'mobile' => 'required|regex:/^\+[1-9]\d{1,14}$/',
    ]);

    $existingUser = Driver::where('mobile', $request->mobile)->first();
    if ($existingUser) {
        return response()->json(['error' => 'This mobile number is already registered.'], 400);
    }


    $otp = rand(100000, 999999);

    $driver = Driver::updateOrCreate(
        ['mobile' => $request->mobile],
        ['otp' => $otp, 'otp_verified' => false]
    );

    try {
        $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
        $twilio->messages->create(
            $request->mobile,
            [
                'from' => env('TWILIO_PHONE_NUMBER'),
                'body' => "Your OTP code is: $otp"
            ]
        );

        return response()->json(['message' => 'OTP sent successfully.']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to send OTP.', 'details' => $e->getMessage()], 500);
    }
}

public function verifyOtp(Request $request)
{
    $request->validate([
        'mobile' => 'required|regex:/^\+[1-9]\d{1,14}$/',
        'otp' => 'required|digits:6',
    ]);

    $driver = Driver::where('mobile', $request->mobile)
        ->where('otp', $request->otp)
        ->first();

    if (!$driver) {
        return response()->json(['error' => 'Invalid OTP.'], 400);
    }

    $driver->update([
        'otp_verified' => true,
        'otp' => null 
    ]);

    return response()->json(['message' => 'OTP verified successfully.']);
}

public function updateProfile(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'password' => 'required|min:8',
        'car_brand' => 'required|string|max:255',
        'car_model' => 'required|string|max:255',
        'car_type' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'license_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'car_plate_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'mobile' => 'required|regex:/^\+[1-9]\d{1,14}$/', 
    ]);

    $driver = Driver::where('mobile', $request->mobile)->first();

    if (!$driver || !$driver->otp_verified) {
        return response()->json(['error' => 'Driver not verified or does not exist.'], 403);
    }

    // تحديث الحقول المطلوبة
    $driver->name = $request->name;
    $driver->password = Hash::make($request->password);
    $driver->car_brand = $request->car_brand;
    $driver->car_model = $request->car_model;

    // رفع الصور وتحديث المسارات في قاعدة البيانات
    if ($request->hasFile('car_type')) {
        $driver->car_type = $request->file('car_type')->store('assets/uploadscar_types');
    }

    if ($request->hasFile('license_image')) {
        $driver->license_image = $request->file('license_image')->store('assets/uploadslicense_images');
    }

    if ($request->hasFile('car_plate_image')) {
        $driver->car_plate_image = $request->file('car_plate_image')->store('assets/uploadsplate_images');
    }

    $driver->save();

    return response()->json(['message' => 'Driver profile updated successfully.', 'driver' => $driver], 200);
}

public function index()
{
    // جلب كل السائقين
    $drivers = Driver::all();
    
    // التحقق من وجود السائقين في القاعدة
    if ($drivers->isEmpty()) {
        return response()->json(['message' => 'No drivers found.'], 404);
    }

    // إرسال كل السائقين في الاستجابة
    return response()->json(['drivers' => $drivers], 200);
}

public function indexDriver($id)
{
    $driver = Driver::find($id);

    if (!$driver) {
        return response()->json(['error' => 'Driver not found.'], 404);
    }

    return response()->json(['driver' => $driver], 200);
}

public function deleteDriver($id)
{
    $driver = Driver::find($id);

    if (!$driver) {
        return response()->json(['error' => 'Driver not found.'], 404);
    }

    // حذف السجل
    $driver->delete();

    return response()->json(['message' => 'Driver deleted successfully.'], 200);
}

}



