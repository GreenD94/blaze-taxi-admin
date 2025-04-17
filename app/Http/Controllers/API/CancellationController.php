<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cancellation;
use App\Models\RideRequest;
use App\Models\Trip;
use Illuminate\Support\Facades\Auth;

class CancellationController extends Controller
{
    /**
     * Registrar una cancelación de viaje.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function cancelTrip(Request $request)
    {
        $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'cancellation_reason_id' => 'required|exists:cancellation_reasons,id',
            'additional_description' => 'nullable|string',
        ]);

        $user = Auth::user();

        // Verificar que el usuario tiene una suscripción activa, si aplica
        // (Implementa la lógica según tu modelo de suscripción)

        // Verificar que el viaje pertenece al usuario y está en un estado cancelable
        $trip = RideRequest::where('id', $request->trip_id)
                    ->where('user_id', $user->id)
                    ->where('status', 'pending') // Ajusta según tus estados de viaje
                    ->firstOrFail();

        // Crear la cancelación
        $cancellation = Cancellation::create([
            'ride_request_id' => $trip->id,
            // 'user_id' => $user->id,
            'cancellation_reason_id' => $request->cancellation_reason_id,
            'additional_description' => $request->additional_description,
        ]);

        // Actualizar el estado del viaje a 'cancelled'
        $trip->status = 'cancelled';
        $trip->save();

        return response()->json([
            'message' => 'Trip cancelled successfully.',
            'cancellation' => $cancellation,
        ], 200);
    }
}
