<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteItem extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }

    public function airConditioner()
    {
        return $this->belongsTo(AirConditioner::class);
    }

    public function contractItem()
    {
        return $this->belongsTo(ContractItem::class);
    }
}
