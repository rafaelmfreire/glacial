<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $dates = ['opened_at'];
    protected $guarded = [];

    public function airConditioner()
    {
        return $this->belongsTo(AirConditioner::class);
    }
}
