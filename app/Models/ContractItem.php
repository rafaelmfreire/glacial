<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function number(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => str_pad($value, 3, '0', STR_PAD_LEFT),
        );
    }

    protected function itemValue(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => number_format($value / 100, 2, '.', ''),
            set: fn ($value) => str_replace('.', '', $value * 100),
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
