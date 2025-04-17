<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RideRequestOffering extends Model
{
    use HasFactory;
    
    protected $table = 'ride_request_offering';

    protected $fillable = [
        'driver_id',
        'fee_offered',
        'ride_request_id'
    ];
}
