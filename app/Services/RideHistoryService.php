<?php

namespace App\Services;

use App\Models\User;
use App\Models\RideRequest;
use App\Models\WalletHistory;
use App\Enums\PaymentType;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class RideHistoryService
{
    /**
     * Get ride history for a driver with filters and pagination
     */
    public function getRideHistory(
        User $driver,
        array $filters = [],
        int $perPage = 10
    ): LengthAwarePaginator {
        try {
            Log::info('Building query for driver: ' . $driver->id);

            $query = $this->buildRideHistoryQuery($driver, $filters);

            Log::info('Query built successfully, getting paginated results');

            $completedRides = $query->paginate($perPage);

            Log::info('Got ' . $completedRides->count() . ' rides');

            // Add historical wallet balance to each ride
            $this->addHistoricalWalletBalance($driver, $completedRides);

            return $completedRides;
        } catch (\Exception $e) {
            Log::error('Error in getRideHistory: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get all ride history for export (without pagination)
     */
    public function getAllRideHistoryForExport(
        User $driver,
        array $filters = []
    ): Collection {
        $query = $this->buildRideHistoryQuery($driver, $filters);

        $completedRides = $query->get();

        // Add historical wallet balance to each ride
        $this->addHistoricalWalletBalance($driver, $completedRides);

        return $completedRides;
    }

    /**
     * Build the base query for ride history
     */
    private function buildRideHistoryQuery(User $driver, array $filters)
    {
        Log::info('Building query with filters: ' . json_encode($filters));

        $query = RideRequest::where('driver_id', $driver->id)
            ->where('status', 'completed')
            ->with(['rider', 'payment', 'driver.userWallet']);

        // Apply date filters
        if (!empty($filters['from_date'])) {
            Log::info('Applying from_date filter: ' . $filters['from_date']);
            $query->whereDate('datetime', '>=', $filters['from_date']);
        }

        if (!empty($filters['to_date'])) {
            Log::info('Applying to_date filter: ' . $filters['to_date']);
            $query->whereDate('datetime', '<=', $filters['to_date']);
        }

        // Apply payment type filter
        if (!empty($filters['payment_type']) && $filters['payment_type'] !== 'all') {
            Log::info('Applying payment_type filter: ' . $filters['payment_type']);

            // Map mobile to mobile-payment for database query
            $paymentType = $filters['payment_type'];
            if ($paymentType === 'mobile') {
                $paymentType = 'mobile-payment';
            }

            $query->where('payment_type', $paymentType);
        }

        $query = $query->orderByDesc('id');

        // Log the final SQL query for debugging
        Log::info('Final SQL Query: ' . $query->toSql());
        Log::info('Query bindings: ' . json_encode($query->getBindings()));

        return $query;
    }

    /**
     * Add historical wallet balance to rides
     */
    private function addHistoricalWalletBalance(User $driver, $rides): void
    {
        Log::info('Adding historical wallet balance to ' . count($rides) . ' rides');

        foreach ($rides as $ride) {
            $ride->historical_wallet_balance = $this->calculateHistoricalWalletBalance(
                $driver->id,
                $ride->datetime
            );
        }

        Log::info('Historical wallet balance added successfully');
    }

    /**
     * Calculate historical wallet balance for a specific date
     */
    public function calculateHistoricalWalletBalance(int $userId, string $rideDateTime): float
    {
        $latestTransaction = WalletHistory::where('user_id', $userId)
            ->where('datetime', '<', $rideDateTime)
            ->orderByDesc('datetime')
            ->first();

        return $latestTransaction?->balance ?? 0.0;
    }

    /**
     * Generate CSV filename for export
     */
    public function generateCsvFilename(User $driver): string
    {
        $driverName = str_replace([' ', '/', '\\'], '_', $driver->display_name);
        return "historial_viajes_{$driverName}_" . date('Y-m-d_H-i-s') . '.csv';
    }

    /**
     * Format payment type for CSV export
     */
    public function formatPaymentTypeForCsv(string $paymentType): string
    {
        $enum = PaymentType::fromString($paymentType);
        return $enum?->label() ?? ucfirst($paymentType);
    }
}
