<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\DataTables\DriverDataTable;
use App\Models\Role;
use App\Http\Requests\DriverRequest;
use App\Models\DriverDocument;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;
use App\Models\RideRequest;
use App\Models\WalletHistory;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(DriverDataTable $dataTable)
    {
        $pageTitle = __('message.list_form_title',['form' => __('message.driver')] );
        $auth_user = authSession();
        if(!empty(request('status'))) {
            $pageTitle = __('message.pending_list_form_title',['form' => __('message.driver')] );
        }
        $assets = ['datatable'];
        $button = $auth_user->can('driver add') ? '<a href="'.route('driver.create').'" class="float-right btn btn-sm btn-primary"><i class="fa fa-plus-circle"></i> '.__('message.add_form_title',['form' => __('message.driver')]).'</a>' : '';
        return $dataTable->with('status', request('status'))->render('global.datatable', compact('assets','pageTitle','button','auth_user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageTitle = __('message.add_form_title',[ 'form' => __('message.driver')]);
        $assets = ['phone'];
        // $selected_service = [];
        return view('driver.form', compact('pageTitle','assets'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DriverRequest $request)
    {
        $request['password'] = bcrypt($request->password);

        $request['username'] = $request->username ?? stristr($request->email, "@", true) . rand(100,1000);
        $request['display_name'] = $request->first_name.' '. $request->last_name;
        $request['user_type'] = 'driver';

        if(auth()->user()->hasRole('fleet')) {
            $request['fleet_id'] = auth()->user()->id;
        }
        $user = User::create($request->all());

        uploadMediaFile($user,$request->profile_image, 'profile_image');
        $user->assignRole('driver');
        // Save Driver detail...
        $user->userDetail()->create($request->userDetail);
        $user->userBankAccount()->create($request->userBankAccount);

        $user->userWallet()->create(['total_amount' => 0 ]);
/*
        if($user->driverService()->count() > 0)
        {
            $user->driverService()->delete();
        }

        if($request->service_id != null) {
            foreach($request->service_id as $service) {
                $driver_services = [
                    'service_id'    => $service->id,
                    'driver_id'     => $user->id,
                ];
                $user->driverService()->insert($driver_services);
            }
        }
*/
        return redirect()->route('driver.index')->withSuccess(__('message.save_form', ['form' => __('driver')]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pageTitle = __('message.view_form_title',[ 'form' => __('message.driver')]);
        $data = User::with('roles','userDetail', 'userBankAccount')->findOrFail($id);
        $data->rating = count($data->driverRating) > 0 ? (float) number_format(max($data->driverRating->avg('rating'),0), 2) : 0;

        $data->cash_earning = Payment::whereHas('riderequest', function($query) use ($data) {
            $query->where('driver_id', $data->id);
        })->where('payment_status', 'paid')->where('payment_type', 'cash')->sum('total_amount') ?? 0;
        $data->wallet_earning = Payment::whereHas('riderequest', function($query) use ($data) {
            $query->where('driver_id', $data->id);
        })->where('payment_status', 'paid')->where('payment_type', 'wallet')->sum('driver_commission') ?? 0;
        $data->total_earning = $data->cash_earning + $data->wallet_earning;

        $profileImage = getSingleMedia($data, 'profile_image');

        return view('driver.show', compact('data', 'profileImage', 'pageTitle'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pageTitle = __('message.update_form_title',[ 'form' => __('message.driver')]);
        $data = User::with('userDetail','userBankAccount')->findOrFail($id);

        $profileImage = getSingleMedia($data, 'profile_image');
        $assets = ['phone'];
/*
        $selected_service = $data->driverService->mapWithKeys(function ($item) {
            return [ $item->service_id => optional($item->service)->name ];
        });
*/
        return view('driver.form', compact('data', 'pageTitle', 'id', 'profileImage', 'assets'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DriverRequest $request, $id)
    {
        $user = User::with('userDetail')->findOrFail($id);

        $request['password'] = $request->password != '' ? bcrypt($request->password) : $user->password;

        $request['display_name'] = $request->first_name.' '. $request->last_name;

        if(auth()->user()->hasRole('fleet')) {
            $request['fleet_id'] = auth()->user()->id;
        }
        // User user data...
        $user->fill($request->all())->update();

        // Save user image...
        if (isset($request->profile_image) && $request->profile_image != null) {
            $user->clearMediaCollection('profile_image');
            $user->addMediaFromRequest('profile_image')->toMediaCollection('profile_image');
        }

        if($user->userDetail != null) {
            $user->userDetail->fill($request->userDetail)->update();
        } else {
            $user->userDetail()->create($request->userDetail);
        }

        if($user->userBankAccount != null) {
            $user->userBankAccount->fill($request->userBankAccount)->update();
        } else {
            $user->userBankAccount()->create($request->userBankAccount);
        }

        /*
        if($user->driverService()->count() > 0)
        {
            $user->driverService()->delete();
        }

        if($request->service_id != null) {
            foreach($request->service_id as $service) {
                $driver_services = [
                    'service_id'    => $service,
                    'driver_id'     => $user->id,
                ];
                $user->driverService()->insert($driver_services);
            }
        }
        */

        if(auth()->check()){
            return redirect()->route('driver.index')->withSuccess(__('message.update_form',['form' => __('message.driver')]));
        }
        return redirect()->back()->withSuccess(__('message.update_form',['form' => __('message.driver') ] ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(env('APP_DEMO')){
            $message = __('message.demo_permission_denied');
            if(request()->ajax()) {
                return response()->json(['status' => true, 'message' => $message ]);
            }
            return redirect()->route('driver.index')->withErrors($message);
        }
        $user = User::findOrFail($id);
        $status = 'errors';
        $message = __('message.not_found_entry', ['name' => __('message.driver')]);

        if($user!='') {
            $user->delete();
            $status = 'success';
            $message = __('message.delete_form', ['form' => __('message.driver')]);
        }

        if(request()->ajax()) {
            return response()->json(['status' => true, 'message' => $message ]);
        }

        return redirect()->back()->with($status,$message);
    }

    private function calculateHistoricalWalletBalance($userId, $rideDateTime)
    {
        // Buscar la transacción más reciente ANTES del viaje (excluyendo las transacciones del viaje actual)
        $latestTransaction = WalletHistory::where('user_id', $userId)
            ->where('datetime', '<', $rideDateTime)
            ->orderByDesc('datetime')
            ->first();

        if ($latestTransaction) {
            return $latestTransaction->balance;
        }

        // Si no hay transacciones anteriores, el saldo era 0
        return 0;
    }

    /**
     * Obtener historial de viajes del conductor
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRideHistory($id)
    {
        \Log::info('getRideHistory called with driver ID: ' . $id);

        $data = User::findOrFail($id);
        \Log::info('Driver found: ' . $data->display_name);

        // Obtener parámetros de filtro
        $fromDate = request('from_date');
        $toDate = request('to_date');
        $paymentType = request('payment_type');
        $perPage = request('per_page', 10);

        // Construir la consulta base
        $query = RideRequest::where('driver_id', $data->id)
            ->where('status', 'completed')
            ->with(['rider', 'payment', 'driver.userWallet']);

        // Aplicar filtros
        if ($fromDate) {
            $query->whereDate('datetime', '>=', $fromDate);
        }

        if ($toDate) {
            $query->whereDate('datetime', '<=', $toDate);
        }

        if ($paymentType && $paymentType !== 'all') {
            $query->where('payment_type', $paymentType);
        }

        // Obtener datos con paginación
        $completedRides = $query->orderByDesc('id')->paginate($perPage);

        // Cargar el saldo histórico de billetera para cada viaje
        foreach($completedRides as $ride) {
            // Calcular el saldo histórico hasta el momento del viaje
            $historicalBalance = $this->calculateHistoricalWalletBalance($data->id, $ride->datetime);

            // Asignar el saldo histórico al viaje
            $ride->historical_wallet_balance = $historicalBalance;
        }

        $response = [
            'status' => true,
            'data' => $completedRides->items(),
            'pagination' => [
                'current_page' => $completedRides->currentPage(),
                'last_page' => $completedRides->lastPage(),
                'per_page' => $completedRides->perPage(),
                'total' => $completedRides->total(),
                'from' => $completedRides->firstItem(),
                'to' => $completedRides->lastItem(),
            ],
            'filters' => [
                'from_date' => $fromDate,
                'to_date' => $toDate,
                'payment_type' => $paymentType,
            ]
        ];

        \Log::info('Response data structure:', [
            'status' => $response['status'],
            'count' => count($response['data']),
            'total' => $response['pagination']['total'],
            'current_page' => $response['pagination']['current_page']
        ]);

        return response()->json($response);
    }

    /**
     * Exportar historial de viajes del conductor a CSV
     *
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function exportRideHistoryCSV($id)
    {
        \Log::info('exportRideHistoryCSV called with driver ID: ' . $id);

        $data = User::findOrFail($id);

        // Obtener parámetros de filtro
        $fromDate = request('from_date');
        $toDate = request('to_date');
        $paymentType = request('payment_type');

        // Construir la consulta base (sin paginación para exportar todo)
        $query = RideRequest::where('driver_id', $data->id)
            ->where('status', 'completed')
            ->with(['rider', 'payment', 'driver.userWallet']);

        // Aplicar filtros
        if ($fromDate) {
            $query->whereDate('datetime', '>=', $fromDate);
        }

        if ($toDate) {
            $query->whereDate('datetime', '<=', $toDate);
        }

        if ($paymentType && $paymentType !== 'all') {
            $query->where('payment_type', $paymentType);
        }

        // Obtener todos los datos
        $completedRides = $query->orderByDesc('id')->get();

        // Cargar el saldo histórico de billetera para cada viaje
        foreach($completedRides as $ride) {
            $historicalBalance = $this->calculateHistoricalWalletBalance($data->id, $ride->datetime);
            $ride->historical_wallet_balance = $historicalBalance;
        }

        $filename = 'historial_viajes_' . $data->display_name . '_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($completedRides) {
            $file = fopen('php://output', 'w');

            // BOM para UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Encabezados del CSV
            fputcsv($file, [
                'ID',
                'Fecha/Hora',
                'Pasajero',
                'Teléfono Pasajero',
                'Monto',
                'Método de Pago',
                'Efectivo Recibido',
                'Efectivo Cobrado',
                'Vuelto',
                'Saldo Billetera',
                'Estado'
            ]);

            // Datos
            foreach ($completedRides as $ride) {
                $rideDate = \Carbon\Carbon::parse($ride->datetime)->format('d/m/Y H:i');
                $riderName = $ride->rider ? ($ride->rider->first_name ?? '') . ' ' . ($ride->rider->last_name ?? '') : '-';
                $riderPhone = $ride->rider ? ($ride->rider->contact_number ?? '-') : '-';

                $paymentTypeText = '';
                switch($ride->payment_type) {
                    case 'cash':
                        $paymentTypeText = 'Efectivo';
                        break;
                    case 'wallet':
                        $paymentTypeText = 'Billetera';
                        break;
                    case 'mobile':
                        $paymentTypeText = 'Móvil';
                        break;
                    default:
                        $paymentTypeText = ucfirst($ride->payment_type ?? 'N/A');
                }

                $collectedCash = $ride->payment && $ride->payment->collected_cash ? number_format($ride->payment->collected_cash, 2) : '-';
                $totalAmount = $ride->payment && $ride->payment->total_amount ? number_format($ride->payment->total_amount, 2) : '-';

                $change = '-';
                if ($ride->payment && $ride->payment->collected_cash && $ride->payment->total_amount) {
                    $change = number_format($ride->payment->collected_cash - $ride->payment->total_amount, 2);
                }

                $walletBalance = $ride->historical_wallet_balance ? number_format($ride->historical_wallet_balance, 2) : '-';

                fputcsv($file, [
                    $ride->id,
                    $rideDate,
                    trim($riderName),
                    $riderPhone,
                    number_format($ride->total_amount, 2),
                    $paymentTypeText,
                    $collectedCash,
                    $totalAmount,
                    $change,
                    $walletBalance,
                    'Completada'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
