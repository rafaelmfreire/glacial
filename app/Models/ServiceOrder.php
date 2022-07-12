<?php

namespace App\Models;

use App\Enums\ServiceOrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceOrder extends Model
{
    use HasFactory;

    protected $guarded  = [];
    protected $casts    = ['status' => ServiceOrderStatus::class];
    protected $dates = ['done_at'];

    public function airConditioner()
    {
        return $this->belongsTo(AirConditioner::class);
    }
}
