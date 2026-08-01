<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
        'merek',
        'model',
        'nomor_plat',
        'tarif_per_hari'
    ];

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }
}