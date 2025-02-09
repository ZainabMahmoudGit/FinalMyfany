<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subservice extends Model {

        use HasFactory;  
          protected $fillable = ['category_id', 'name'];
    public function category() {
        return $this->belongsTo(ServiceCategory::class);
    }
    public function packages() {
        return $this->hasMany(Package::class);
    }
}