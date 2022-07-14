<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequisitionItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }

    public function requisition()
    {
        return $this->belongsTo(Requisition::class);
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
