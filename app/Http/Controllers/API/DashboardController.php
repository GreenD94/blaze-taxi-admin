<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RideRequest;
use App\Models\Setting;
use App\Models\Region;
use App\Models\User;
use App\Models\AppSetting;
use App\Http\Resources\SettingResource;
use App\Http\Resources\RegionResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\RiderDashboardResource;
use App\Http\Resources\DriverDashboardResource;
use App\Models\CancellationReason;
use Grimzy\LaravelMysqlSpatial\Types\Point;

class DashboardController extends Controller
{
    public function appsetting(Request $request)
    {
        $data['app_setting'] = AppSetting::first();
        
        $data['terms_condition'] = Setting::where('type','terms_condition')->where('key','terms_condition')->first();
        $data['privacy_policy'] = Setting::where('type','privacy_policy')->where('key','privacy_policy')->first();

        $currency_code = SettingData('CURRENCY', 'CURRENCY_CODE') ?? 'USD';
        $currency = currencyArray($currency_code);
        
        $data['currency_setting'] = [
            'name' => $currency['name'] ?? 'United States (US) dollar',
            'symbol' => $currency['symbol'] ?? '$',
            'code' => strtolower($currency['code']) ?? 'usd',
            'position' => SettingData('CURRENCY', 'CURRENCY_POSITION') ?? 'left',
        ];
        return json_custom_response($data);
    }

    public function adminDashboard(Request $request)
    {
        
        $dashboard_data = $this->commonDashboard($request);

        return json_custom_response($dashboard_data);
    }

    public function riderDashboard(Request $request)
    {

        $dashboard_data = $this->commonDashboard($request);

        return json_custom_response($dashboard_data);
    }

    public function commonDashboard($request)
    {
        $region = Region::where('status', 1);
        $region->when(request('region_id'), function ($q) {
            return $q->where('id', request('region_id'));
        });
        if( $request->has('latitude') && isset($request->latitude) && $request->has('longitude') && isset($request->longitude) )
        {
            $point = new Point($request->latitude, $request->longitude);
            $region->contains('coordinates', $point);
        }
        $region = $region->first();
        $data['region'] = new RegionResource($region);
        $data['app_seeting'] = AppSetting::first();
        
        $data['terms_condition'] = Setting::where('type','terms_condition')->where('key','terms_condition')->first();
        $data['privacy_policy'] = Setting::where('type','privacy_policy')->where('key','privacy_policy')->first();

        $ride_setting = Setting::where('type','ride')->get();
        $data['ride_setting'] = SettingResource::collection($ride_setting);

        $wallet_setting = Setting::where('type','wallet')->get();
        $data['Wallet_setting'] = SettingResource::collection($wallet_setting);

        $currency_code = SettingData('CURRENCY', 'CURRENCY_CODE') ?? 'USD';
        $currency = currencyArray($currency_code);
        
        $data['currency_setting'] = [
            'name' => $currency['name'] ?? 'United States (US) dollar',
            'symbol' => $currency['symbol'] ?? '$',
            'code' => strtolower($currency['code']) ?? 'usd',
            'position' => SettingData('CURRENCY', 'CURRENCY_POSITION') ?? 'left',
        ];

        $data['referrals_enabled'] = SettingData('referrals', 'REFERRALS_ENABLED') == '1';

        // add usd rate
        $data['usd_rate'] = getBcvUsdRate();

        // cancellation reasons
        $data['cancellation_reasons'] = CancellationReason::select(["id", "name", "description"])->get();

        return $data;
    }

    public function currentRideRequest(Request $request)
    {
        $auth_user = auth()->user();
        $user = User::find($auth_user->id);
        $response = null;

        if($user->hasRole('driver')) {
            $response = new DriverDashboardResource($user);
        } else {
            $response = new RiderDashboardResource($user);            
        }
        return json_custom_response($response);
    }

    public function getReferralInfo(Request $request)
    {
        $referralCode = '';
        $status = false;
        $title = 'Referral Code';
        $subTitle = '';
        $response = [
            'ref_code' => $referralCode,
            'status' => $status,
            'title' => $title,
            'subTitle' => $subTitle,
        ];

        $response['title'] = SettingData('referrals', 'REFERRALS_TITLE') ?? $title;
        $response['sub_title'] = SettingData('referrals', 'REFERRALS_SUBTITLE') ?? $subTitle;

        if (!SettingData('referrals', 'REFERRALS_ENABLED')) {
            return json_custom_response(['ref_code' => '', 'status' => false]);
        }

        $user = User::find(auth()->id());

        if ($user->ref_code) {
            $referralCode = $user->ref_code;
            // return json_custom_response(['ref_code' => $user->ref_code, 'status' => true]);
        } else {
            $referralCode = generateRefererCode($user);
            $user->ref_code = $referralCode;
            $user->save();
        }

        $response['ref_code'] = $referralCode;
        $response['status'] = true;

        return json_custom_response($response);
    }
}
