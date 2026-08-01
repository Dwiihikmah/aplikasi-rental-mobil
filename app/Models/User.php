<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'alamat',
        'nomor_telepon',
        'nomor_sim',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }
}