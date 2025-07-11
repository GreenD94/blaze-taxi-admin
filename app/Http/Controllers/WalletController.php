<?php

namespace App\Http\Controllers;

use App\DataTables\RoleDataTable;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{

    public function index($riderId){
        $rider = User::find($riderId);
        return view('wallet.index',compact(['rider']));
    }
    
    public function saveWallet(Request $request)
    {
        $data = $request->all();
        $user_id = request()->user_id ?? auth()->user()->id;
        $data['user_id'] = $user_id;
        $wallet =  Wallet::firstOrCreate(
            [ 'user_id' => $user_id ]
        );

        if( $data['type'] == 'credit' ) {
            $total_amount = $wallet->total_amount + $data['amount'];
        }

        if( $data['type'] == 'debit' ) {
            $total_amount = $wallet->total_amount - $data['amount'];
        }
        $wallet->currency = $data['currency'];
        $wallet->total_amount = $total_amount;
        $message = __('message.save_form',[ 'form' => __('message.wallet') ] );
        try
        {
            DB::beginTransaction();
            $wallet->save();
            $data['balance'] = $total_amount;
            $data['datetime'] = date('Y-m-d H:i:s');
            $result = WalletHistory::updateOrCreate(['id' => $request->id], $data);
            DB::commit();
        } catch(\Exception $e) {
            DB::rollBack();
            return json_custom_response($e);
        }

        return response()->json(['status' => true,'event' => 'refresh' , 'message' => $message]);
        // return json_message_response($message);
    }

    public function getWallatDetail(Request $request)
    {
        $wallet_data = Wallet::where('user_id', auth()->user()->id)->first();

        if( $wallet_data == null ) {
            $message = __('message.not_found_entry',['name' => __('message.wallet')]);
            return json_message_response($message,400);
        }
        $min_amount_to_get_ride = SettingData('wallet', 'min_amount_to_get_ride') ?? 0;
        $response = [
            'wallet_data' => $wallet_data ?? null,
            'min_amount_to_get_ride' => (int) $min_amount_to_get_ride,
            'total_amount'  => $wallet_data->total_amount,
        ];
        return json_custom_response($response);
    }
}
