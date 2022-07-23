<?php

namespace App\Models;

use App\Enums\ServiceOrderStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceOrder extends Model
{
    use HasFactory;

    protected $guarded  = [];
    protected $casts    = ['status' => ServiceOrderStatus::class];
    protected $dates    = ['done_at'];
    protected $appends  = array('status_abbr', 'done_at_formatted', 'done_at_time');

    protected function doneAtFormatted(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) =>
                Carbon::createFromFormat('Y-m-d H:i:s', $attributes['done_at'])->format('d/m/Y')
        );
    }

    protected function doneAtTime(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) =>
                Carbon::createFromFormat('Y-m-d H:i:s', $attributes['done_at'])->format('H:i')
        );
    }

    public function getStatusNameAttribute()
    {
        return __('messages.status.'.$this->status->name);
    }

    public function getStatusAbbrAttribute()
    {
        return __('messages.status_abbr.'.$this->status->name);
    }

    public function airConditioner()
    {
        return $this->belongsTo(AirConditioner::class);
    }
}
