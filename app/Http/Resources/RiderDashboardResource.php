<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Sos;

class RiderDashboardResource extends JsonResource
{
    public function toArray($request)
    {
        $ride_request = $this->riderRideRequestDetail()
                            ->where('is_schedule', 0)
                            ->where('driver_id', null)
                            ->whereNotIn('status', ['canceled','completed'])
                            ->where('is_rider_rated', false)
                            ->orderByDesc('id')
                            ->first();

        $on_ride_request = $this->riderRideRequestDetail()
                                ->where('driver_id', '!=', null)
                                ->whereNotIn('status', ['canceled'])
                                ->where('is_rider_rated',false)
                                ->orderByDesc('id')
                        // ->whereHas('payment',function ($q) {
                        //     $q->where('payment_status', 'pending');
                        // })
                        ->first();

        $pending_payment_ride_request = $this->riderRideRequestDetail()->where('status', 'completed')
                        ->whereHas('payment',function ($q) {
                            $q->where('payment_status', 'pending');
                        })
                        ->orderByDesc('id')
                        ->first();

        $driver = isset($on_ride_request) && optional($on_ride_request->driver) ? $on_ride_request->driver : null;
        $payment = isset($pending_payment_ride_request) && optional($pending_payment_ride_request->payment) ? $pending_payment_ride_request->payment : null;

        //$is_rider_rated = isset($on_ride_request) && $on_ride_request->rideRequestRating()->where('driver_id', $on_ride_request->driver_id)->first();

        $is_completed = false;
        if (isset($on_ride_request) && $on_ride_request !== null) {
            $is_completed = $on_ride_request->status == 'completed' &&
                           $on_ride_request->payment != null &&
                           $on_ride_request->payment->payment_status == 'paid';
        }

        return [
            'id'                => $this->id,
            'display_name'      => $this->display_name,
            'email'             => $this->email,
            'username'          => $this->username,
            'user_type'         => $this->user_type,
            'profile_image'     => getSingleMedia($this, 'profile_image',null),
            'status'            => $this->status,
            // 'sos'               => Sos::mySOs()->get(),
            'ride_request'      => isset($ride_request) ? new RideRequestResource($ride_request) : null,
            'on_ride_request'   => isset($on_ride_request) && !$is_completed  ? new RideRequestResource($on_ride_request) : null,
            'driver'            => isset($driver) ? new DriverResource($driver) : null,
            'payment'           => isset($payment) ? new PaymentResource($payment) : null,
        ];
    }
}