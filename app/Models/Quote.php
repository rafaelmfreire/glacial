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

    public function quoteItems()
    {
        return $this->hasMany(QuoteItem::class);
    }

    public function requisitions()
    {
        return $this->hasMany(Requisition::class);
    }
}
