<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Package extends Model {
  
        use HasFactory;  
    protected $fillable = ['subservice_id', 'name', 'price', 'quantity', 'total_price', 'description'];
    public function subservice() {
        return $this->belongsTo(Subservice::class);
    }
}