<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AirConditionerFile extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function airConditioner()
    {
        return $this->belongsTo(AirConditioner::class);
    }
}
