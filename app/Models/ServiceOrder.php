<?php

namespace App\Models;

use App\Enums\ServiceOrderStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceOrder extends Model
{
    use HasFactory;

    protected $guarded  = [];
    protected $casts    = ['status' => ServiceOrderStatus::class];
    protected $dates    = ['done_at'];
    protected $appends  = array('status_abbr');

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
