<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subservice extends Model {
    protected $fillable = ['category_id', 'name'];
    public function category() {
        return $this->belongsTo(ServiceCategory::class);
    }
    public function packages() {
        return $this->hasMany(Package::class);
    }
}