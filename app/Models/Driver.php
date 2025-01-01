<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'mobile', 'otp', 'otp_verified', 'password',
        'car_brand', 'car_model', 'car_type',
        'license_image', 'car_plate_image',
    ];

    protected $hidden = [
        'password', 'otp',
    ];
}
