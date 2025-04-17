<?php

namespace App\Console\Commands;

use App\Http\Resources\RideRequestResource;
use App\Jobs\NotifyViaMqtt;
use App\Models\RideRequest;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckExpiredRides extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:expired_rides';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Expired Rides';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $expiredTime = (float) SettingData('ride', 'max_time_for_find_drivers_for_regular_ride_in_minute'); // minutes

        $rides = RideRequest::where(function ($query) {
            $query->where('status', 'new_ride_requested')
                ->orWhere('status', 'drivers_offering');
        })->where('created_at', '<', Carbon::now()->subMinutes($expiredTime))
        ->get();

        foreach ($rides as $ride) {
            $ride->status = 'canceled';
            $ride->save();

            $rideRequest = RideRequest::findOrFail($ride->id);

            $notify_data = new \stdClass();
            $notify_data->success = true;
            $notify_data->success_type = 'canceled';
            $notify_data->success_message = 'Ride request has been canceled';
            $notify_data->result = new RideRequestResource($rideRequest);

            $drivers = getNearbyDrivers($rideRequest);

            foreach ($drivers as $driver) {
                dispatch(new NotifyViaMqtt('new_ride_request_'.$driver->id, json_encode($notify_data)));
            }

        }

        // info
        if (count($rides) > 0) {
            $this->info('Expired rides found: ' . count($rides));
        } else {
            $this->info('No expired rides found ' . Carbon::now()->toDateTimeString() . ' - ' . $expiredTime . ' minutes');
        }

        return 0;
    }
}
