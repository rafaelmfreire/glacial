<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AirConditioner extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function serviceOrders()
    {
        return $this->hasMany(ServiceOrder::class);
    }

    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }

    public function requisitions()
    {
        return $this->hasMany(Requisition::class);
    }
}
