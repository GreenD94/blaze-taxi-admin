<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bonus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'amount',
        'rides_qty',
        'start_date_type',
        'starts_at',
        'end_date_type',
        'ends_at',
        'days_to_expiration',
        'status'
    ];

    protected $dates = [
        'starts_at',
        'ends_at'
    ];

    protected $casts = [
        'amount' => 'float',
        'rides_qty' => 'integer',
    ];

    // protected $appends = ['start_date', 'end_date'];


    // public function getStartDateAttribute() {

    //     if ($this->start_date_type == 'fixed') {
    //         return $this->starts_at;
    //     } else if ($this->start_date_type == 'verification_date') {
    //         $driver = auth()->user();
    //         return $driver ? $driver->driverDocument()
    //             ->whereHas('document', function ($q) {
    //                 $q->where('is_required', 1);
    //             })
    //             ->orderBy('updated_at', 'desc')->first()->updated_at : null;
    //     }
    // }

    // public function getEndDateAttribute()
    // {
    //     if ($this->end_date_type == 'fixed') {
    //         return $this->ends_at;
    //     } else if ($this->end_date_type == 'days_to_expiration') {
    //         $endDate = new Carbon($this->start_date);
    //         $endDate->addDays($this->days_to_expiration);
    //         return $endDate;
    //     }
    // }

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps()->withPivot(['amount', 'status']);
    }


}
