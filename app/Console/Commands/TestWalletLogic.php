<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\RideRequest;
use App\Models\Payment;
use App\Models\Wallet;
use App\Models\WalletHistory;
use App\Models\User;
use App\Traits\PaymentTrait;
use Illuminate\Support\Facades\DB;

class TestWalletLogic extends Command
{
    use PaymentTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:wallet-logic {ride_request_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test wallet logic for cash payments';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $rideRequestId = $this->argument('ride_request_id');

        if ($rideRequestId) {
            $this->testSpecificRide($rideRequestId);
        } else {
            $this->testAllCashPayments();
        }

        return 0;
    }

    private function testSpecificRide($rideRequestId)
    {
        $this->info("Testing ride request ID: {$rideRequestId}");

        $rideRequest = RideRequest::with(['payment', 'driver.userWallet', 'rider.userWallet'])->find($rideRequestId);

        if (!$rideRequest) {
            $this->error("Ride request not found!");
            return;
        }

        $this->info("Ride Request Details:");
        $this->info("- Status: {$rideRequest->status}");
        $this->info("- Total Amount: {$rideRequest->total_amount}");
        $this->info("- Payment Type: {$rideRequest->payment_type}");

        if ($rideRequest->payment) {
            $this->info("Payment Details:");
            $this->info("- Payment Status: {$rideRequest->payment->payment_status}");
            $this->info("- Total Amount: {$rideRequest->payment->total_amount}");
            $this->info("- Collected Cash: {$rideRequest->payment->collected_cash}");
            $this->info("- Admin Commission: {$rideRequest->payment->admin_commission}");
            $this->info("- Driver Commission: {$rideRequest->payment->driver_commission}");
        }

        if ($rideRequest->driver && $rideRequest->driver->userWallet) {
            $this->info("Driver Wallet:");
            $this->info("- Current Balance: {$rideRequest->driver->userWallet->total_amount}");
        }

        // Check wallet history for this ride
        $walletHistory = WalletHistory::where('ride_request_id', $rideRequestId)
            ->where('user_id', $rideRequest->driver_id)
            ->orderBy('datetime', 'asc')
            ->get();

        $this->info("Wallet History for Driver:");
        foreach ($walletHistory as $history) {
            $this->info("- Type: {$history->type}, Transaction: {$history->transaction_type}, Amount: {$history->amount}, Balance: {$history->balance}, DateTime: {$history->datetime}");
        }
    }

    private function testAllCashPayments()
    {
        $this->info("Testing all cash payments...");

        $cashPayments = Payment::where('payment_type', 'cash')
            ->where('payment_status', 'paid')
            ->with(['riderequest.driver.userWallet', 'riderequest.rider.userWallet'])
            ->get();

        $this->info("Found {$cashPayments->count()} cash payments");

        foreach ($cashPayments as $payment) {
            $this->info("\n--- Payment ID: {$payment->id} ---");
            $this->info("Ride Request ID: {$payment->ride_request_id}");
            $this->info("Total Amount: {$payment->total_amount}");
            $this->info("Collected Cash: {$payment->collected_cash}");
            $this->info("Admin Commission: {$payment->admin_commission}");
            $this->info("Driver Commission: {$payment->driver_commission}");

            if ($payment->riderequest && $payment->riderequest->driver) {
                $driverWallet = $payment->riderequest->driver->userWallet;
                $this->info("Driver Current Wallet Balance: " . ($driverWallet ? $driverWallet->total_amount : 'No wallet'));

                // Check if there are debit transactions for this payment
                $debitTransactions = WalletHistory::where('ride_request_id', $payment->ride_request_id)
                    ->where('user_id', $payment->riderequest->driver_id)
                    ->where('type', 'debit')
                    ->get();

                if ($debitTransactions->count() > 0) {
                    $this->info("✅ Found {$debitTransactions->count()} debit transactions:");
                    foreach ($debitTransactions as $transaction) {
                        $this->info("  - {$transaction->transaction_type}: {$transaction->amount} (Balance: {$transaction->balance})");
                    }
                } else {
                    $this->warn("❌ No debit transactions found for this cash payment!");
                }
            }
        }
    }
}
