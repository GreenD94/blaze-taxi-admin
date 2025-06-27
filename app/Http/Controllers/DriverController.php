<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\DataTables\DriverDataTable;
use App\Models\Role;
use App\Http\Requests\DriverRequest;
use App\Http\Requests\RideHistoryRequest;
use App\Http\Resources\RideHistoryResource;
use App\Models\DriverDocument;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;
use App\Models\RideRequest;
use App\Models\WalletHistory;
use App\Services\RideHistoryService;
use App\Enums\RideStatus;
use App\Enums\PaymentType;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DriverController extends Controller
{
    protected RideHistoryService $rideHistoryService;

    public function __construct(RideHistoryService $rideHistoryService)
    {
        $this->rideHistoryService = $rideHistoryService;
    }

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

    /**
     * Get ride history for a driver
     *
     * @param int $id
     * @param RideHistoryRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRideHistory($id, RideHistoryRequest $request)
    {
        try {
            Log::info('getRideHistory called with driver ID: ' . $id);

            $driver = User::findOrFail($id);
            Log::info('Driver found: ' . $driver->display_name);

            $validated = $request->validated();

            $completedRides = $this->rideHistoryService->getRideHistory(
                $driver,
                $validated,
                $validated['per_page']
            );

            $response = [
                'status' => true,
                'data' => RideHistoryResource::collection($completedRides),
                'pagination' => [
                    'current_page' => $completedRides->currentPage(),
                    'last_page' => $completedRides->lastPage(),
                    'per_page' => $completedRides->perPage(),
                    'total' => $completedRides->total(),
                    'from' => $completedRides->firstItem(),
                    'to' => $completedRides->lastItem(),
                ],
                'filters' => [
                    'from_date' => $validated['from_date'] ?? null,
                    'to_date' => $validated['to_date'] ?? null,
                    'payment_type' => $validated['payment_type'] ?? null,
                ]
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('Error in getRideHistory: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'status' => false,
                'message' => 'Error al cargar el historial de viajes: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export ride history to CSV
     *
     * @param int $id
     * @param RideHistoryRequest $request
     * @return StreamedResponse
     */
    public function exportRideHistoryCSV($id, RideHistoryRequest $request)
    {
        try {
            Log::info('exportRideHistoryCSV called with driver ID: ' . $id);

            $driver = User::findOrFail($id);
            $validated = $request->validated();

            $completedRides = $this->rideHistoryService->getAllRideHistoryForExport($driver, $validated);
            $filename = $this->rideHistoryService->generateCsvFilename($driver);

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
                    'Efectivo Cobrado',
                    'Vuelto',
                    'Saldo Billetera',
                    'Estado'
                ]);

                // Datos
                foreach ($completedRides as $ride) {
                    $riderName = $ride->rider ? trim(($ride->rider->first_name ?? '') . ' ' . ($ride->rider->last_name ?? '')) : '-';
                    $riderPhone = $ride->rider ? ($ride->rider->contact_number ?? '-') : '-';

                    $paymentTypeText = $this->rideHistoryService->formatPaymentTypeForCsv($ride->payment_type);

                    $totalAmount = $ride->payment?->total_amount ? number_format($ride->payment->total_amount, 2) : '-';

                    $change = '-';
                    if ($ride->payment?->collected_cash && $ride->payment?->total_amount) {
                        $change = number_format($ride->payment->collected_cash - $ride->payment->total_amount, 2);
                    }

                    $walletBalance = $ride->historical_wallet_balance ? number_format($ride->historical_wallet_balance, 2) : '-';

                    fputcsv($file, [
                        $ride->id,
                        Carbon::parse($ride->datetime)->format('d/m/Y H:i'),
                        $riderName,
                        $riderPhone,
                        number_format($ride->total_amount, 2),
                        $paymentTypeText,
                        $totalAmount,
                        $change,
                        $walletBalance,
                        'Completada'
                    ]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        } catch (\Exception $e) {
            Log::error('Error in exportRideHistoryCSV: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'status' => false,
                'message' => 'Error al exportar el historial: ' . $e->getMessage()
            ], 500);
        }
    }
}
