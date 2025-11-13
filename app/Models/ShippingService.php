<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShippingService extends Model
{
    use HasFactory, SoftDeletes;
    
    public $timestamps = false; 

    protected $fillable = [
        'name',
        'code',
        'estimation',
        'is_active',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
