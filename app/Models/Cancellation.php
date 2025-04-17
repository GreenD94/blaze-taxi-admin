<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cancellation extends Model
{
    use HasFactory;

    protected $fillable = [
        'ride_request_id',
        'cancellation_reason_id',
        // 'additional_description',
    ];

    /**
     * Obtener el viaje asociado a la cancelación.
     */
    public function riderequest(){
        return $this->belongsTo(RideRequest::class, 'ride_request_id', 'id');
    }

    /**
     * Obtener el usuario que realizó la cancelación.
     */
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    /**
     * Obtener el motivo de cancelación.
     */
    public function cancellationReason()
    {
        return $this->belongsTo(CancellationReason::class, 'cancellation_reason_id');
    }
}
