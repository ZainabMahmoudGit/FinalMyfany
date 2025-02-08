<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model {
    protected $fillable = ['name', 'image'];
    public function subservices() {
        return $this->hasMany(Subservice::class);
    }
}

