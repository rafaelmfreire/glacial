<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractItem extends Model
{
    use HasFactory;

    public function quotes()
    {
        return $this->hasMany(quotes::class);
    }

    public function requisitions()
    {
        return $this->hasMany(Requisition::class);
    }
}
