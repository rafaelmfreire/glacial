<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $dates = ['date'];
    protected $appends = array('date_formatted');

    protected function dateFormatted(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) =>
                Carbon::createFromFormat('Y-m-d', $attributes['date'])->format('d/m/Y')
        );
    }

    public function quoteItems()
    {
        return $this->hasMany(QuoteItem::class);
    }

    public function requisitionItems()
    {
        return $this->hasMany(RequisitionItem::class);
    }
}
