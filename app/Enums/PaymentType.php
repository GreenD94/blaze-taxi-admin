<?php

namespace App\Enums;

enum PaymentType: string
{
    case CASH = 'cash';
    case WALLET = 'wallet';
    case MOBILE = 'mobile';
    case MOBILE_PAYMENT = 'mobile-payment';

    public function label(): string
    {
        return match($this) {
            self::CASH => 'Efectivo',
            self::WALLET => 'Billetera',
            self::MOBILE => 'Móvil',
            self::MOBILE_PAYMENT => 'Pago Móvil',
        };
    }

    public function badgeClass(): string
    {
        return match($this) {
            self::CASH => 'badge-success',
            self::WALLET => 'badge-primary',
            self::MOBILE => 'badge-warning',
            self::MOBILE_PAYMENT => 'badge-warning',
        };
    }

    public function gradientStyle(): string
    {
        return match($this) {
            self::CASH => 'background: linear-gradient(135deg, #28a745 0%, #20c997 100%);',
            self::WALLET => 'background: linear-gradient(135deg, #007bff 0%, #6610f2 100%);',
            self::MOBILE => 'background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);',
            self::MOBILE_PAYMENT => 'background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);',
        };
    }

    public static function fromString(string $value): ?self
    {
        return match($value) {
            'cash' => self::CASH,
            'wallet' => self::WALLET,
            'mobile' => self::MOBILE,
            'mobile-payment' => self::MOBILE_PAYMENT,
            default => null,
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
