<?php

namespace App\Traits;
use Illuminate\Http\Request;
use App\Models\RideRequest;
use App\Models\User;
use App\Models\Payment;
use App\Models\Wallet;
use App\Models\WalletHistory;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;

trait PaymentTrait {
    
    public function walletTransaction($ride_request_id) {
        $ride_request = RideRequest::where('id', $ride_request_id)->first();
        
        if( $ride_request == null ) {
            return false;
        }

        $admin_id = User::admin()->id;
        $payment = $ride_request->payment;

        $commission_type = $ride_request->service->commission_type ?? 0;
        $admin_commission = $ride_request->service->admin_commission ?? 0;

        $fleet_id = optional($ride_request->driver)->fleet_id;
        
        $fleet_commission = 0;
        if( $fleet_id != null ) {
            $fleet_commission = $ride_request->service->fleet_commission ?? 0;
        }
        // tips not added in the riderequest total_amount
        // tips and extra_charges_amount added in the driver_commission
        $ride_request_amount = $ride_request->total_amount - $ride_request->extra_charges_amount;
        // $ride_request_amount = $payment->total_amount - $ride_request->extra_charges_amount;
        // if( $commission_type == 'fixed' ) {
        //     $commission_amount = $admin_commission;
        // }
        if( $commission_type == 'percentage' ) {
            $admin_commission = $admin_commission ? ( $ride_request_amount / 100) * $admin_commission: 0;

            if( $fleet_id != null ) {
                $fleet_commission = $fleet_commission ? ( $ride_request_amount / 100) * $fleet_commission: 0;
            }
        }
        
        if( $payment->payment_type == 'cash') {
            $payment->received_by = 'driver';
        } elseif ($payment->payment_type == 'wallet') {
            $payment->received_by = 'wallet';
        } else {
            $payment->received_by = 'admin';
        }
        $driver_tips = $ride_request->tips ?? 0;
        $payment->admin_commission = $admin_commission;
        $payment->fleet_commission = $fleet_commission;
        $driver_fee = $ride_request_amount - $admin_commission - $fleet_commission;
        $payment->driver_fee = $driver_fee;
        $payment->driver_tips = $driver_tips;
        $payment->driver_commission = $driver_fee + $driver_tips + $ride_request->extra_charges_amount;
        $payment->save();
        
        // $currency = optional($ride_request->service) && optional($ride_request->service)->region ? optional($ride_request->service)->region->currency_code : null;

        $currency_code = SettingData('CURRENCY', 'CURRENCY_CODE') ?? 'USD';
        $currency_data = currencyArray($currency_code);
        $currency = strtolower($currency_data['code']);
        try {
            DB::beginTransaction();
            if( $payment->payment_type == 'wallet' )
            {
                $driver_wallet = Wallet::firstOrCreate(
                    [ 'user_id' => $ride_request->driver_id ]
                );
                $driver_wallet->total_amount += $payment->driver_commission;
                $driver_wallet->save();

                $driver_wallet_history = [
                    'user_id'           => $ride_request->driver_id,
                    'type'              => 'credit',
                    'transaction_type'  => 'ride_fee',
                    'currency'          => $currency,
                    'amount'            => $payment->driver_commission,
                    'balance'           => $driver_wallet->total_amount,
                    'ride_request_id'   => $payment->ride_request_id,
                    'datetime'          => date('Y-m-d H:i:s'),
                    'data' => [
                        'payment_id'    => $payment->id,
                        'tips'          => $payment->driver_tips
                    ]
                ];
                WalletHistory::create($driver_wallet_history);

                $admin_wallet = Wallet::firstOrCreate(
                    [ 'user_id' => $admin_id ]
                );
                
                $admin_wallet->total_amount = $admin_wallet->total_amount + $admin_commission;
                $admin_wallet->save();

                $admin_wallet_history = [ 
                    'user_id'           => $admin_id,
                    'type'              => 'credit',
                    'transaction_type'  => 'admin_commission',
                    'currency'          => $currency,
                    'amount'            => $admin_commission,
                    'balance'           => $admin_wallet->total_amount,
                    'ride_request_id'   => $payment->ride_request_id,
                    'datetime'          => date('Y-m-d H:i:s'),
                    'data' => [
                        'payment_id'    => $payment->id
                    ]
                ];
                WalletHistory::create($admin_wallet_history);

                if( $fleet_id != null ) {
                    $fleet_wallet = Wallet::firstOrCreate(
                        [ 'user_id' => $fleet_id ]
                    );
                    $fleet_wallet->total_amount = $fleet_wallet->total_amount + $fleet_commission;
                    $fleet_wallet->save();

                    $fleet_wallet_history = [ 
                        'user_id'           => $fleet_id,
                        'type'              => 'credit',
                        'transaction_type'  => 'fleet_commision',
                        'currency'          => $currency,
                        'amount'            => $fleet_commission,
                        'balance'           => $fleet_wallet->total_amount,
                        'ride_request_id'   => $payment->ride_request_id,
                        'datetime'          => date('Y-m-d H:i:s'),
                        'data' => [
                            'payment_id' => $payment->id
                        ]
                    ];

                    WalletHistory::create($fleet_wallet_history);
                }
            }elseif ($payment->payment_type == 'cash') {
            /*
                $driver_wallet = Wallet::firstOrCreate(
                    [ 'user_id' => $ride_request->driver_id ]
                );
                $driver_wallet->collected_cash += $payment->total_amount;
                $driver_wallet->total_amount = $payment->driver_fee + $payment->driver_tips;
                $driver_wallet->save();

                $driver_wallet_history = [
                    'user_id'           => $ride_request->driver_id,
                    'type'              => 'credit',
                    'transaction_type'  => 'ride_fee',
                    'currency'          => $currency,
                    'amount'            => $payment->driver_fee,
                    'balance'           => $driver_wallet->total_amount,
                    'ride_request_id'   => $payment->ride_request_id,
                    'data' => [
                        'payment_id'    => $payment->id,
                        'tips'          => $payment->driver_tips,                    
                    ]
                ];
                WalletHistory::create($driver_wallet_history);
            */

                $admin_wallet = Wallet::firstOrCreate(
                    [ 'user_id' => $admin_id ]
                );
                $admin_wallet->total_amount = $admin_wallet->total_amount + $admin_commission;
                $admin_wallet->save();

                $admin_wallet_history = [ 
                    'user_id'           => $admin_id,
                    'type'              => 'credit',
                    'transaction_type'  => 'admin_commission',
                    'currency'          => $currency,
                    'amount'            => $admin_commission,
                    'balance'           => $admin_wallet->total_amount,
                    'ride_request_id'   => $payment->ride_request_id,
                    'datetime'          => date('Y-m-d H:i:s'),
                    'data' => [
                        'payment_id'    => $payment->id
                    ]
                ];
                WalletHistory::create($admin_wallet_history);

                $driver_wallet = Wallet::firstOrCreate(
                    [ 'user_id' => $ride_request->driver_id ]
                );
                $driver_wallet->total_amount -= $admin_commission;
                $driver_wallet->save();

                $driver_wallet_history = [
                    'user_id'           => $ride_request->driver_id,
                    'type'              => 'debit',
                    'transaction_type'  => 'correction',
                    'currency'          => $currency,
                    'amount'            => $admin_commission,
                    'balance'           => $driver_wallet->total_amount,
                    'ride_request_id'   => $payment->ride_request_id,
                    'datetime'          => date('Y-m-d H:i:s'),
                ];
                WalletHistory::create($driver_wallet_history);
                
                // refund cash difference
                $difference = $ride_request->total_amount - $payment->total_amount;

                if ($difference > 0) {

                    $driver_wallet = Wallet::firstOrCreate(
                        [ 'user_id' => $ride_request->driver_id ]
                    );
                    $driver_wallet->total_amount += $difference;
                    $driver_wallet->save();
    
                    $driver_wallet_history = [
                        'user_id'           => $ride_request->driver_id,
                        'type'              => 'credit',
                        'transaction_type'  => 'refund_cash_difference',
                        'currency'          => $currency,
                        'amount'            => $difference,
                        'balance'           => $driver_wallet->total_amount,
                        'ride_request_id'   => $payment->ride_request_id,
                        'datetime'          => date('Y-m-d H:i:s'),
                    ];
                    WalletHistory::create($driver_wallet_history);

                }

                $collectedCash = $payment->collected_cash ?? 0;
                $outstanding = $payment->total_amount;

                $rider_wallet = Wallet::firstOrCreate(
                    [ 'user_id' => $ride_request->rider_id ]
                );

                $outstanding = max(0, $payment->total_amount - $rider_wallet->total_amount);

                if ($rider_wallet->total_amount >= $ride_request->total_amount) {
                    // El saldo es suficiente para cubrir el costo total
                    singleWalletTransaction($ride_request->rider_id, $ride_request->total_amount, 'debit');
                } else {
                    // El saldo es insuficiente
                    // Deducir el saldo disponible del cliente
                    singleWalletTransaction($ride_request->rider_id, $rider_wallet->total_amount, 'debit');
                }

                if ($collectedCash > $outstanding) {

                    $rider_wallet = Wallet::firstOrCreate(
                        [ 'user_id' => $ride_request->rider_id ]
                    );

                    $rider_wallet->total_amount += $collectedCash - $outstanding;
                    $rider_wallet->save();
        
                    $rider_wallet_history = [
                        'user_id'           => $ride_request->rider_id,
                        'type'              => 'credit',
                        'transaction_type'  => 'cash_back',
                        'currency'          => $currency,
                        'amount'            => $collectedCash - $outstanding,
                        'balance'           => $rider_wallet->total_amount,
                        'ride_request_id'   => $payment->ride_request_id,
                        'datetime'          => date('Y-m-d H:i:s'),
                    ];

                    WalletHistory::create($rider_wallet_history);

                    // depositCashDifferenceToRiderWallet($ride_request);
                    
                    $driver_wallet = Wallet::firstOrCreate(
                        [ 'user_id' => $ride_request->driver_id ]
                    );

                    $driver_wallet->total_amount -= $collectedCash - $payment->total_amount;
                    $driver_wallet->save();
        
                    $driver_wallet_history = [
                        'user_id'           => $ride_request->driver_id,
                        'type'              => 'debit',
                        'transaction_type'  => 'collected_cash_back',
                        'currency'          => $currency,
                        'amount'            => $collectedCash - $payment->total_amount,
                        'balance'           => $driver_wallet->total_amount,
                        'ride_request_id'   => $payment->ride_request_id,
                        'datetime'          => date('Y-m-d H:i:s'),
                    ];

                    WalletHistory::create($driver_wallet_history);

                }

                if( $fleet_id != null ) {
                    $fleet_wallet = Wallet::firstOrCreate(
                        [ 'user_id' => $fleet_id ]
                    );
                    $fleet_wallet->total_amount = $fleet_wallet->total_amount + $fleet_commission;
                    $fleet_wallet->save();

                    $fleet_wallet_history = [ 
                        'user_id'           => $fleet_id,
                        'type'              => 'credit',
                        'transaction_type'  => 'fleet_commision',
                        'currency'          => $currency,
                        'amount'            => $fleet_commission,
                        'balance'           => $fleet_wallet->total_amount,
                        'ride_request_id'   => $payment->ride_request_id,
                        'datetime'          => date('Y-m-d H:i:s'),
                        'data' => [
                            'payment_id' => $payment->id
                        ]
                    ];
                    WalletHistory::create($fleet_wallet_history);

                
                    $driver_wallet = Wallet::firstOrCreate(
                        [ 'user_id' => $ride_request->driver_id ]
                    );
                    $driver_wallet->total_amount -= $fleet_commission;
                    $driver_wallet->save();
        
                    $driver_wallet_history = [
                        'user_id'           => $ride_request->driver_id,
                        'type'              => 'debit',
                        'transaction_type'  => 'correction',
                        'currency'          => $currency,
                        'amount'            => $fleet_commission,
                        'balance'           => $driver_wallet->total_amount,
                        'ride_request_id'   => $payment->ride_request_id,
                        'datetime'          => date('Y-m-d H:i:s'),
                    ];
                    WalletHistory::create($driver_wallet_history);
                
                }
            }else {
                $driver_wallet = Wallet::firstOrCreate(
                    [ 'user_id' => $ride_request->driver_id ]
                );
                $driver_wallet->total_amount += $payment->driver_commission;
                $driver_wallet->save();

                $driver_wallet_history = [
                    'user_id'           => $ride_request->driver_id,
                    'type'              => 'credit',
                    'transaction_type'  => 'ride_fee',
                    'currency'          => $currency,
                    'amount'            => $payment->driver_commission,
                    'balance'           => $driver_wallet->total_amount,
                    'ride_request_id'   => $payment->ride_request_id,
                    'datetime'          => date('Y-m-d H:i:s'),
                    'data' => [
                        'payment_id'    => $payment->id,
                        'tips'          => $payment->driver_tips,                    
                    ]
                ];
                WalletHistory::create($driver_wallet_history);
            /*
                $admin_wallet = Wallet::firstOrCreate(
                    [ 'user_id' => $admin_id ]
                );

                $admin_wallet->online_received += $payment->total_amount;
                $admin_wallet->total_amount += $admin_commission;
                $admin_wallet->save();

                $admin_wallet_history = [ 
                    'user_id'           => $admin_id,
                    'type'              => 'credit',
                    'transaction_type'  => 'admin_commission',
                    'currency'          => $currency,
                    'amount'            => $admin_commission,
                    'balance'           => $admin_wallet->total_amount,
                    'ride_request_id'   => $payment->ride_request_id,
                    'data' => [
                        'payment_id'    => $payment->id
                    ]
                ];
                WalletHistory::create($admin_wallet_history);
            */
                $admin_wallet = Wallet::firstOrCreate(
                    [ 'user_id' => $admin_id ]
                );
                $admin_wallet->total_amount -= $payment->driver_commission;
                $admin_wallet->save();

                $admin_wallet_history = [
                    'user_id'           => $ride_request->driver_id,
                    'type'              => 'debit',
                    'transaction_type'  => 'correction',
                    'currency'          => $currency,
                    'amount'            => $payment->driver_commission,
                    'balance'           => $admin_wallet->total_amount,
                    'ride_request_id'   => $payment->ride_request_id,
                    'datetime'          => date('Y-m-d H:i:s'),
                ];
                WalletHistory::create($admin_wallet_history);

                if( $fleet_id != null ) {
                    $fleet_wallet = Wallet::firstOrCreate(
                        [ 'user_id' => $fleet_id ]
                    );
                    $fleet_wallet->total_amount = $fleet_wallet->total_amount + $fleet_commission;
                    $fleet_wallet->save();

                    $fleet_wallet_history = [ 
                        'user_id'           => $fleet_id,
                        'type'              => 'credit',
                        'transaction_type'  => 'fleet_commision',
                        'currency'          => $currency,
                        'amount'            => $fleet_commission,
                        'balance'           => $fleet_wallet->total_amount,
                        'ride_request_id'   => $payment->ride_request_id,
                        'datetime'          => date('Y-m-d H:i:s'),
                        'data' => [
                            'payment_id' => $payment->id
                        ]
                    ];
                    WalletHistory::create($fleet_wallet_history);

                    $admin_wallet = Wallet::firstOrCreate(
                        [ 'user_id' => $admin_id ]
                    );
                    $admin_wallet->total_amount -= $fleet_commission;
                    $admin_wallet->save();
        
                    $admin_wallet_history = [
                        'user_id'           => $ride_request->driver_id,
                        'type'              => 'debit',
                        'transaction_type'  => 'correction',
                        'currency'          => $currency,
                        'amount'            => $fleet_commission,
                        'balance'           => $admin_wallet->total_amount,
                        'ride_request_id'   => $payment->ride_request_id,
                        'datetime'          => date('Y-m-d H:i:s'),
                    ];
                    WalletHistory::create($admin_wallet_history);
                }
            }
            DB::commit();
        } catch(\Exception $e) {
            // \Log::error($e->getMessage());
            DB::rollBack();
            return json_custom_response($e);
        }
        
        return true;
    }
}