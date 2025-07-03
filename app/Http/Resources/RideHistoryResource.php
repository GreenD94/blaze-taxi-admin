<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Enums\PaymentType;
use Carbon\Carbon;

class RideHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request)
    {
        $paymentType = PaymentType::fromString($this->payment_type);

        return [
            'id' => $this->id,
            'datetime' => $this->datetime,
            'formatted_datetime' => Carbon::parse($this->datetime)->format('d/m/Y H:i'),
            'total_amount' => $this->total_amount,
            'formatted_total_amount' => number_format($this->total_amount, 2),
            'payment_type' => $this->payment_type,
            'payment_type_label' => $paymentType?->label() ?? ucfirst($this->payment_type),
            'payment_type_gradient' => $paymentType?->gradientStyle(),
            'status' => $this->status,
            'rider' => [
                'id' => $this->rider?->id,
                'first_name' => $this->rider?->first_name,
                'last_name' => $this->rider?->last_name,
                'full_name' => trim(($this->rider?->first_name ?? '') . ' ' . ($this->rider?->last_name ?? '')),
                'contact_number' => $this->rider?->contact_number,
            ],
            'payment' => [
                'collected_cash' => $this->payment?->collected_cash,
                'formatted_collected_cash' => $this->payment?->collected_cash ? number_format($this->payment->collected_cash, 2) : null,
                'total_amount' => $this->payment?->total_amount,
                'formatted_total_amount' => $this->payment?->total_amount ? number_format($this->payment->total_amount, 2) : null,
                'change' => $this->calculateChange(),
                'formatted_change' => $this->calculateFormattedChange(),
            ],
            'historical_wallet_balance' => $this->historical_wallet_balance,
            'formatted_historical_wallet_balance' => $this->historical_wallet_balance ? number_format($this->historical_wallet_balance, 2) : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    /**
     * Calculate the change amount
     */
    private function calculateChange()
    {
        if (!$this->payment || !$this->payment->collected_cash || !$this->total_amount) {
            return null;
        }

        return $this->payment->collected_cash - $this->total_amount;
    }

    /**
     * Calculate the formatted change amount
     */
    private function calculateFormattedChange()
    {
        $change = $this->calculateChange();

        return $change !== null ? number_format($change, 2) : null;
    }
}
