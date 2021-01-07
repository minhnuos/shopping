<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;
    public function subDistricts() {
        return $this->hasMany(SubDistrict::class,'districts_id');
    }
}
