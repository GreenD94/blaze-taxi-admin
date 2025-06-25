<?php

namespace App\Enums;

enum RideStatus: string
{
    case NEW_RIDE_REQUESTED = 'new_ride_requested';
    case DRIVERS_OFFERING = 'drivers_offering';
    case REJECTED_BY_RIDER = 'rejected-by-rider';
    case ACCEPTED = 'accepted';
    case ARRIVED = 'arrived';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';
    case CANCELLED = 'canceled';

    public function label(): string
    {
        return match($this) {
            self::NEW_RIDE_REQUESTED => 'Nueva Solicitud',
            self::DRIVERS_OFFERING => 'Conductores Ofreciendo',
            self::REJECTED_BY_RIDER => 'Rechazado por Pasajero',
            self::ACCEPTED => 'Aceptado',
            self::ARRIVED => 'Llegó',
            self::IN_PROGRESS => 'En Progreso',
            self::COMPLETED => 'Completado',
            self::CANCELLED => 'Cancelado',
        };
    }

    public function badgeClass(): string
    {
        return match($this) {
            self::NEW_RIDE_REQUESTED => 'badge-info',
            self::DRIVERS_OFFERING => 'badge-warning',
            self::REJECTED_BY_RIDER => 'badge-danger',
            self::ACCEPTED => 'badge-primary',
            self::ARRIVED => 'badge-info',
            self::IN_PROGRESS => 'badge-warning',
            self::COMPLETED => 'badge-success',
            self::CANCELLED => 'badge-danger',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
