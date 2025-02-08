<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model {
    protected $fillable = ['subservice_id', 'name', 'price', 'quantity', 'total_price', 'description'];
    public function subservice() {
        return $this->belongsTo(Subservice::class);
    }
}