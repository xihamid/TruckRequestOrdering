<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Order extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'user_id', 'pickup_location', 'delivery_location', 'size', 'weight',
        'pickup_datetime', 'delivery_datetime', 'status',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getOrdersWithUsers()
    {
        return self::with('user')->get(); // Eager load the user relationship
    }


}
