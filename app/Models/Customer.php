<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable 
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = ['id'];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime'
    ];

    // public function routeNotificationForMail(Notification $notification): array|string
    // {
    //     // Return email address and name...
    //     return [$this->email_address => $this->name];
    // }

    public function orders()
    {
        $this->hasMany(Order::class);
    }



}
