<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DriverDocument;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\DriverResource;
use Illuminate\Support\Facades\Password;
use App\Models\AppSetting;
use Carbon\Carbon;
use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\DriverRequest;
use Propaganistas\LaravelPhone\PhoneNumber;
class UserController extends Controller
{
    public function register(UserRequest $request)
    {
        $input = $request->all();
                
        $password = $input['password'];
        $input['user_type'] = isset($input['user_type']) ? $input['user_type'] : 'rider';
        $input['password'] = Hash::make($password);

        if( in_array($input['user_type'],['driver']))
        {
            $input['status'] = isset($input['status']) ? $input['status']: 'pending';
        }

        if($request->ref_code) {

            // $input['applied_ref_code'] = $request->ref_code;
            
            $ref_status = SettingData('referrals', 'REFERRALS_ENABLED');

            if ($ref_status != '1') {
                return json_custom_response([ 'data' => 'referrals disabled' ], 403 );
            }

            $referar_user = User::where('ref_code', '=', $request->ref_code)->first();
            
            if (!$referar_user || !$referar_user->status) {
                return json_custom_response([ 'data' => 'not found' ], 405 );
            }

            // applied ref code
            $ref_code_applied = $request->ref_code;

        }

        $input['display_name'] = $input['first_name']." ".$input['last_name'];
        $user = User::create($input);
        $user->assignRole($input['user_type']);

        if( $request->has('user_detail') && $request->user_detail != null ) {
            $user->userDetail()->create($request->user_detail);
        }

        $message = __('message.save_form',['form' => __('message.'.$input['user_type']) ]);
        $user->api_token = $user->createToken('auth_token')->plainTextToken;
        $user->profile_image = getSingleMedia($user, 'profile_image', null);
        $response = [
            'message' => $message,
            'data' => $user
        ];
        return json_custom_response($response);
    }

    public function driverRegister(DriverRequest $request)
    {
        $input = $request->all();
        $password = $input['password'];
        $input['user_type'] = isset($input['user_type']) ? $input['user_type'] : 'driver';
        $input['password'] = Hash::make($password);

        $input['status'] = isset($input['status']) ? $input['status']: 'pending';

        $input['display_name'] = $input['first_name']." ".$input['last_name'];
        $input['is_available'] = 1;
        $user = User::create($input);
        $user->assignRole($input['user_type']);

        if( $request->has('user_detail') && $request->user_detail != null ) {
            $user->userDetail()->create($request->user_detail);
        }
        
        if( $request->has('user_bank_account') && $request->user_bank_account != null ) {
            $user->userBankAccount()->create($request->user_bank_account);
        }
        $user->userWallet()->create(['total_amount' => 0 ]);

        $message = __('message.save_form',['form' => __('message.driver') ]);
        $user->api_token = $user->createToken('auth_token')->plainTextToken;
        $user->is_verified_driver = (int) $user->is_verified_driver;// DriverDocument::verifyDriverDocument($user->id);
        $user->profile_image = getSingleMedia($user, 'profile_image', null);
        $response = [
            'message' => $message,
            'data' => $user
        ];
        return json_custom_response($response);
    }

    public function login(Request $request)
    {      
        if(Auth::attempt(['email' => request('email'), 'password' => request('password'), 'user_type' => request('user_type')])){
            
            $user = Auth::user();

            if( $user->status == 'banned' ) {
                $message = __('message.account_banned');
                return json_message_response($message,400);
            }

            if(request('player_id') != null){
                $user->player_id = request('player_id');
            }

            if(request('fcm_token') != null){
                $user->fcm_token = request('fcm_token');
            }
            
            $user->save();
            
            $success = $user;
            $success['api_token'] = $user->createToken('auth_token')->plainTextToken;
            $success['profile_image'] = getSingleMedia($user,'profile_image',null);
            $is_verified_driver = false;
            if($user->user_type == 'driver') {
                $is_verified_driver = $user->is_verified_driver; // DriverDocument::verifyDriverDocument($user->id);
            }
            $success['is_verified_driver'] = (int) $is_verified_driver;
            unset($success['media']);

            return json_custom_response([ 'data' => $success ], 200 );
        }
        else{
            $message = __('auth.failed');
            
            return json_message_response($message,400);
        }
    }

    public function userList(Request $request)
    {
        $user_type = isset($request['user_type']) ? $request['user_type'] : 'rider';
        
        $user_list = User::query();
        
        $user_list->when(request('user_type'), function ($q) use($user_type) {
            return $q->where('user_type', $user_type);
        });

        $user_list->when(request('fleet_id'), function ($q) {
            return $q->where('fleet_id', request('fleet_id'));
        });

        if( $request->has('is_online') && isset($request->is_online) )
        {
            $user_list = $user_list->where('is_online',request('is_online'));
        }
        
        if( $request->has('status') && isset($request->status) )
        {
            $user_list = $user_list->where('status',request('status'));
        }

        $per_page = config('constant.PER_PAGE_LIMIT');
        if( $request->has('per_page') && !empty($request->per_page))
        {
            if(is_numeric($request->per_page)){
                $per_page = $request->per_page;
            }
            if($request->per_page == -1 ){
                $per_page = $user_list->count();
            }
        }
        
        $user_list = $user_list->paginate($per_page);

        if( $user_type == 'driver' ) {
            $items = DriverResource::collection($user_list);
        } else {
            $items = UserResource::collection($user_list);
        }

        $response = [
            'pagination' => json_pagination_response($items),
            'data' => $items,
        ];
        
        return json_custom_response($response);
    }

    public function userDetail(Request $request)
    {
        $id = $request->id;

        $user = User::where('id',$id)->first();
        if(empty($user))
        {
            $message = __('message.user_not_found');
            return json_message_response($message,400);   
        }

        if( $user->user_type == 'driver') {
            $user_detail = new DriverResource($user);
        } else {
            $user_detail = new UserResource($user);
        }

        $response = [
            'data' => $user_detail
        ];
        return json_custom_response($response);

    }

    public function changePassword(Request $request){
        $user = User::where('id',Auth::user()->id)->first();

        if($user == "") {
            $message = __('message.user_not_found');
            return json_message_response($message,400);   
        }
           
        $hashedPassword = $user->password;

        $match = Hash::check($request->old_password, $hashedPassword);

        $same_exits = Hash::check($request->new_password, $hashedPassword);
        if ($match)
        {
            if($same_exits){
                $message = __('message.old_new_pass_same');
                return json_message_response($message,400);
            }

			$user->fill([
                'password' => Hash::make($request->new_password)
            ])->save();
            
            $message = __('message.password_change');
            return json_message_response($message,200);
        }
        else
        {
            $message = __('message.valid_password');
            return json_message_response($message,400);
        }
    }

    public function updateProfile(UserRequest $request)
    {   
        $user = Auth::user();
        if($request->has('id') && !empty($request->id)){
            $user = User::where('id',$request->id)->first();
        }
        if($user == null){
            return json_message_response(__('message.no_record_found'),400);
        }

        $user->fill($request->all())->update();

        if(isset($request->profile_image) && $request->profile_image != null ) {
            $user->clearMediaCollection('profile_image');
            $user->addMediaFromRequest('profile_image')->toMediaCollection('profile_image');
        }

        $user_data = User::find($user->id);
        
        if($user_data->userDetail != null && $request->has('user_detail') ) {
            $user_data->userDetail->fill($request->user_detail)->update();
        } else if( $request->has('user_detail') && $request->user_detail != null ) {
            $user_data->userDetail()->create($request->user_detail);
        }
        
        if($user_data->userBankAccount != null && $request->has('user_bank_account')) {
            $user_data->userBankAccount->fill($request->user_bank_account)->update();
        } else if( $request->has('user_bank_account') && $request->user_bank_account != null ) {
            $user_data->userBankAccount()->create($request->user_bank_account);
        }
        
        $message = __('message.updated');
        // $user_data['profile_image'] = getSingleMedia($user_data,'profile_image',null);
        unset($user_data['media']);

        if( $user_data->user_type == 'driver') {
            $user_resource = new DriverResource($user_data);
        } else {
            $user_resource = new UserResource($user_data);
        }

        $response = [
            'data' => $user_resource,
            'message' => $message
        ];
        return json_custom_response( $response );
    }

    public function updatePhoneNumber(Request $request)
    {   

        $request->validate([
            'contact_number' => 'phone:VE,EC'
        ]);

        $phone = new PhoneNumber($request->contact_number, 'VE,EC');
        $formattedPhone = str_replace("-", "", $phone->formatNational());
        $formattedPhone = str_replace("0", "", $formattedPhone);
        $formattedPhone = str_replace(" ", "", $formattedPhone);

        //return $formattedPhone;

        $validatePhoneNumber = User::where('contact_number', 'like', '%' . $formattedPhone . '%')->first();

        //return $validatePhoneNumber;
        //return auth()->user()->contact_number;

        if ($validatePhoneNumber && $phone->equals($validatePhoneNumber->contact_number, 'VE')) {
            // $phone = new PhoneNumber($request->contact_number, 'VE');
            // $isEqual = $phone->equals('+584123333331', 'VE');
            // $formattedPhone = str_replace("-", "", $phone->formatNational());
            // $formattedPhone = str_replace("0", "", $formattedPhone);
            //$isEqual = $phone->equals($validatePhoneNumber->contact_number, 'VE');

            //return json_message_response( $validatePhoneNumber->contact_number  , 400);
            return json_message_response('El número de teléfono indicado ya está en uso.', 400);
        }

        $user = Auth::user();

        if($request->has('id') && !empty($request->id)){
            $user = User::where('id',$request->id)->first();
        }

        if($user == null){
            return json_message_response(__('message.no_record_found'),400);
        }

        $updatedData = [
            'contact_number' => $request->contact_number,
            'username' =>  0 .$formattedPhone
        ];

        $user->fill($updatedData)->update();
        
        $message = __('message.updated');

        if( $user->user_type == 'driver') {
            $user_resource = new DriverResource($user);
        } else {
            $user_resource = new UserResource($user);
        }

        $response = [
            'data' => $user_resource,
            'message' => $message
        ];

        return json_custom_response( $response );
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        if($request->is('api*')){
            $clear = request('clear');
            if( $clear != null ) {
                $user->$clear = null;
            }
            $user->save();
            return json_message_response('Logout successfully');
        }
    }

    public function forgetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $response = Password::sendResetLink(
            $request->only('email')
        );

        return $response == Password::RESET_LINK_SENT
            ? response()->json(['message' => __($response), 'status' => true], 200)
            : response()->json(['message' => __($response), 'status' => false], 400);
    }
    
    public function socialLogin(Request $request)
    {
        $input = $request->all();

        if($input['login_type'] === 'mobile'){
            $user_data = User::where('username', $input['username'])->first();
        } else {
            $user_data = User::where('email',$input['email'])->first();
        }
        
        if( $user_data != null ) {
            if( !in_array($user_data->user_type, ['admin',request('user_type')] )) {
                $message = __('auth.failed');
                return json_message_response($message,400);
            }

            if( $user_data->status == 'banned' ) {
                $message = __('message.account_banned');
                return json_message_response($message,400);
            }
        
            if( !isset($user_data->login_type) || $user_data->login_type  == '' )
            {
                if($request->login_type === 'google')
                {
                    $message = __('validation.unique',['attribute' => 'email' ]);
                } elseif ($request->login_type === 'mobile') {

                } else {
                    $message = __('validation.unique',['attribute' => 'username' ]);
                }
                //return json_message_response($message,400);
            }
            $message = __('message.login_success');
        } else {

            if($request->login_type === 'google')
            {
                $key = 'email';
                $value = $request->email;
            } else {
                $key = 'username';
                $value = $request->username;
            }

            if($request->login_type === 'mobile' && $user_data == null ){
                $otp_response = [
                    'status' => true,
                    'is_user_exist' => false
                ];
                return json_custom_response($otp_response);
            }

            $password = !empty($input['accessToken']) ? $input['accessToken'] : $input['email'];

            $input['display_name'] = $input['first_name']." ".$input['last_name'];
            $input['password'] = Hash::make($password);
            $input['user_type'] = isset($input['user_type']) ? $input['user_type'] : 'rider';
            $user = User::create($input);
            if($user->userWallet == null) {
                $user->userWallet()->create(['total_amount' => 0 ]);
            }
            $user->assignRole($input['user_type']);

            $user_data = User::where('id',$user->id)->first();
            $message = __('message.save_form',['form' => $input['user_type'] ]);
        }

        $user_data['api_token'] = $user_data->createToken('auth_token')->plainTextToken;
        $user_data['profile_image'] = getSingleMedia($user_data, 'profile_image', null);

        $is_verified_driver = false;
        if($user_data->user_type == 'driver') {
            $is_verified_driver = $user_data->is_verified_driver; // DriverDocument::verifyDriverDocument($user_data->id);
        }
        $user_data['is_verified_driver'] = (int) $is_verified_driver;
        $response = [
            'status' => true,
            'message' => $message,
            'data' => $user_data
        ];
        return json_custom_response($response);
    }

    public function updateUserStatus(Request $request)
    {
        $user_id = $request->id ?? auth()->user()->id;
        
        $user = User::where('id',$user_id)->first();

        if($user == "") {
            $message = __('message.user_not_found');
            return json_message_response($message,400);
        }
        if($request->has('status')) {
            $user->status = $request->status;
        }
        if($request->has('is_online')) {
            $user->is_online = $request->is_online;
        }
        if($request->has('is_available')) {
            $user->is_available = $request->is_available;
        }
        if($request->has('latitude')) {
            $user->latitude = $request->latitude;
        }
        if($request->has('longitude')) {
            $user->longitude = $request->longitude;
        }
        if($request->has('latitude') && $request->has('longitude') ) {
            $user->last_location_update_at = date('Y-m-d H:i:s');
        }
        $user->save();

        if( $user->user_type == 'driver') {
            $user_resource = new DriverResource($user);
        } else {
            $user_resource = new UserResource($user);
        }
        $message = __('message.update_form',['form' => __('message.status') ]);
        $response = [
            'data' => $user_resource,
            'message' => $message
        ];
        return json_custom_response($response);
    }

    public function updateAppSetting(Request $request)
    {
        $data = $request->all();
        AppSetting::updateOrCreate(['id' => $request->id],$data);
        $message = __('message.save_form',['form' => __('message.app_setting') ]);
        $response = [
            'data' => AppSetting::first(),
            'message' => $message
        ];
        return json_custom_response($response);
    }

    public function getAppSetting(Request $request)
    {
        if($request->has('id') && isset($request->id)){
            $data = AppSetting::where('id',$request->id)->first();
        } else {
            $data = AppSetting::first();
        }

        return json_custom_response($data);
    }

    public function deleteUserAccount(Request $request)
    {
        $id = auth()->id();
        $user = User::where('id', $id)->first();
        $message = __('message.not_found_entry',['name' => __('message.account') ]);

        if( $user != '' ) {
            $user->delete();
            $message = __('message.account_deleted');
        }
        
        return json_custom_response(['message'=> $message, 'status' => true]);
    }

    // public function deleteUserAccount(Request $request)

    //check reffer code

    public function checkRefCode(Request $request)
    {

        $reffer_code = $request->ref_code;

        $ref_status = SettingData('referrals', 'REFERRALS_ENABLED');

        if ($ref_status != '1') {
            return json_custom_response(['message' => 'referrals disabled', 'status' => false, 'ref_code' => $reffer_code]);
        }

        $referar_user = User::where('ref_code', $reffer_code)->first();

        if (!$referar_user || !$referar_user->status == 'active') {
            return json_custom_response(['message' => 'not found', 'status' => false, 'ref_code' => $reffer_code]);
        }

        return json_custom_response(['message' => 'referral code is valid', 'status' => true, 'ref_code' => $reffer_code]);
    }

    //check if referrals is enabled
    public function checkReferralsEnabled() {

        $ref_status = SettingData('referrals', 'REFERRALS_ENABLED');
        if ($ref_status != '1') {
            return json_custom_response(['message' => 'referrals disabled', 'status' => false]);
        }
        return json_custom_response(['message' => 'referrals enabled', 'status' => true]);
    }
}
