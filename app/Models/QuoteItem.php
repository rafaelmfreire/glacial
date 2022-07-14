<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class QuoteItem extends Model
{
    use HasFactory;
    
    protected $dates = ['service_date'];
    protected $guarded = [];
    protected $appends = array('service_date_formatted');

    protected function serviceDateFormatted(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) =>
                Carbon::createFromFormat('Y-m-d', $attributes['service_date'])->format('d/m/Y')
        );
    }

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
