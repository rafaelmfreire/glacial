<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function airConditioner()
    {
        return $this->belongsTo(AirConditioner::class);
    }

    public function contractItem()
    {
        return $this->belongsTo(ContractItem::class);
    }

    public function requisitions()
    {
        return $this->hasMany(Requisition::class);
    }
}
