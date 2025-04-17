<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CancellationReason extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'active'];

    /**
     * Obtener todas las cancelaciones asociadas a este motivo.
     */
    public function cancellations()
    {
        return $this->hasMany(Cancellation::class, 'cancellation_reason_id');
    }
}
