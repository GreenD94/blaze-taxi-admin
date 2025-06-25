<x-master-layout>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-block card-stretch">
                <div class="card-body p-0">
                    <div class="d-flex justify-content-between align-items-center p-3">
                        <h5 class="font-weight-bold">{{ $pageTitle }}</h5>
                        <a href="{{ route('driver.index') }}" class="float-right btn btn-sm btn-primary"><i class="fa fa-angle-double-left"></i> {{ __('message.back') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="card card-block p-card">
                <div class="profile-box">
                    <div class="profile-card rounded">
                        <img src="{{ $profileImage }}" alt="01.jpg" class="avatar-100 rounded d-block mx-auto img-fluid mb-3">
                        <h3 class="font-600 text-white text-center mb-0">{{ $data->display_name }}</h3>
                        <p class="text-white text-center mb-5">
                            @php
                                $status = 'danger';
                                $status_label = __('message.offline');
                                switch ($data->is_online) {
                                    case '1':
                                        $status = 'success';
                                        $status_label = __('message.online');
                                        break;
                                }
                            @endphp
                            <span class="badge bg-{{$status}}">{{ $status_label }}</span>

                            @if( $data->is_available == 1 )
                                <span class="badge bg-success">{{ __('message.in_service') }}</span>
                            @endif
                        </p>
                    </div>
                    <div class="pro-content rounded">
                        <div class="d-flex align-items-center mb-3">
                            <div class="p-icon mr-3">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <p class="mb-0 eml">{{ $data->email }}</p>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <div class="p-icon mr-3">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <p class="mb-0">{{ $data->contact_number }}</p>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <div class="p-icon mr-3">

                                @if( $data->gender == 'female' )
                                    <i class="fas fa-female"></i>
                                @elseif( $data->gender == 'other' )
                                    <i class="fas fa-transgender"></i>
                                @else
                                    <i class="fas fa-male"></i>
                                @endif
                            </div>
                            <p class="mb-0">{{ $data->gender }}</p>
                        </div>
                        @php
                            $rating = $data->rating ?? 0;
                        @endphp
                        @if( $rating > 0 )
                            <div class="d-flex justify-content-center">
                                <div class="social-ic d-inline-flex rounded">
                                    @while($rating > 0 )
                                        @if($rating > 0.5)
                                            <i class="fas fa-star" style="color: yellow"></i>
                                        @else
                                            <i class="fas fa-star-half" style="color: yellow"></i>
                                        @endif
                                        @php $rating--; @endphp
                                    @endwhile
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card card-block">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title mb-0">{{ __('message.detail_form_title', [ 'form' => __('message.service') ]) }}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <img src="{{ getSingleMedia($data->service, 'service_image',null) }}" alt="service-detail" class="img-fluid avatar-60 rounded-small">
                        </div>
                        <div class="col-9">
                            <p class="mb-0">{{ optional($data->service)->name }}</p>
                            <p class="mb-0">{{ optional($data->userDetail)->car_model }} ( {{ optional($data->userDetail)->car_color }} )</p>
                            <p class="mb-0">{{ optional($data->userDetail)->car_plate_number }}</p>
                            <p class="mb-0">{{ optional($data->userDetail)->car_production_year }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="row">
                <div class="card card-block">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title mb-0">{{ __('message.detail_form_title', [ 'form' => __('message.bank') ]) }}</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <h5>{{ __('message.bank_name') }}</h5>
                                <p class="mb-0">{{ optional($data->userBankAccount)->bank_name ?? '-' }}</p>
                            </div>
                            <div class="col-6">
                                <h5>{{ __('message.bank_code') }}</h5>
                                <p class="mb-0">{{ optional($data->userBankAccount)->bank_code ?? '-' }}</p>
                            </div>
                            <div class="col-6">
                                <h5>{{ __('message.account_holder_name') }}</h5>
                                <p class="mb-0">{{ optional($data->userBankAccount)->account_holder_name ?? '-' }}</p>
                            </div>
                            <div class="col-6">
                                <h5>{{ __('message.account_number') }}</h5>
                                <p class="mb-0">{{ optional($data->userBankAccount)->account_number ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-block">
                        <div class="card-body">
                            <div class="top-block-one">
                                <p class="mb-1">{{ __('message.total_earning') }}</p>
                                <p></p>
                                <h5>{{ getPriceFormat( $data->total_earning ) ?? 0 }} </h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card card-block">
                        <div class="card-body">
                            <div class="top-block-one">
                                <p class="mb-1">{{ __('message.cash_earning') }}</p>
                                <p></p>
                                <h5>{{ getPriceFormat( $data->cash_earning ) ?? 0 }} </h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card card-block">
                        <div class="card-body">
                            <div class="top-block-one">
                                <p class="mb-1">{{ __('message.wallet_earning') }}</p>
                                <p></p>
                                <h5>{{ getPriceFormat( $data->wallet_earning ) ?? 0 }} </h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card card-block">
                        <div class="card-body">
                            <div class="top-block-one">
                                <p class="mb-1">{{ __('message.wallet_balance') }}</p>
                                <p></p>
                                <h5>{{ getPriceFormat(optional($data->userWallet)->total_amount) ?? 0 }} </h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card card-block">
                        <div class="card-body">
                            <div class="top-block-one">
                                <div class="">
                                    <p class="mb-1">{{ __('message.total_withdraw') }}</p>
                                    <p></p>
                                    <h5>{{ getPriceFormat(optional($data->userWallet)->total_withdraw) ?? 0 }} </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card card-block">
                        <div class="card-body">
                            <div class="top-block-one text-center">
                                <div class="">
                                    <p class="mb-3">{{ __('message.view_ride_history') }}</p>
                                    <button type="button" class="btn btn-primary btn-sm loadRemoteModel" data-toggle="modal" data-target="#rideHistoryModal">
                                        <i class="fas fa-history"></i> {{ __('message.view_ride_history') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Historial de Viajes -->
<div class="modal fade" id="rideHistoryModal" tabindex="-1" role="dialog" aria-labelledby="rideHistoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rideHistoryModalLabel">
                    {{ __('message.view_ride_history') }} - {{ $data->display_name }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Fecha/Hora</th>
                                <th>Pasajero</th>
                                <th>Monto</th>
                                <th>Método</th>
                                <th>Efectivo Recibido</th>
                                <th>Efectivo Cobrado</th>
                                <th>Vuelto</th>
                                <th>Saldo Billetera</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($completedRides as $ride)
                                <tr>
                                    <td>#{{ $ride->id }}</td>
                                    <td>{{ \Carbon\Carbon::parse($ride->datetime)->format('d/m/Y H:i') }}</td>
                                    <td>
                                        {{ $ride->rider->first_name ?? '-' }} {{ $ride->rider->last_name ?? '' }}<br>
                                        <span class="text-muted" style="font-size: 0.9em;">{{ $ride->rider->contact_number ?? '-' }}</span>
                                    </td>
                                    <td><strong>${{ number_format($ride->total_amount, 2) }}</strong></td>
                                    <td>
                                        @if($ride->payment_type === 'cash')
                                            <span class="badge badge-success">Efectivo</span>
                                        @elseif($ride->payment_type === 'wallet')
                                            <span class="badge badge-primary">Billetera</span>
                                        @elseif($ride->payment_type === 'mobile')
                                            <span class="badge badge-warning" style="color:#fff;">Móvil</span>
                                        @else
                                            <span class="badge badge-secondary">{{ ucfirst($ride->payment_type) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($ride->payment && $ride->payment->collected_cash)
                                            ${{ number_format($ride->payment->collected_cash, 2) }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if($ride->payment && $ride->payment->total_amount)
                                            ${{ number_format($ride->payment->total_amount, 2) }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if($ride->payment && $ride->payment->collected_cash && $ride->payment->total_amount)
                                            ${{ number_format($ride->payment->collected_cash - $ride->payment->total_amount, 2) }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($ride->historical_wallet_balance))
                                            ${{ number_format($ride->historical_wallet_balance, 2) }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td><span class="badge badge-success">Completada</span></td>
                                    <td><button class="btn btn-info btn-sm"><i class="fa fa-eye"></i> Ver</button></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center">No hay viajes completados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('message.close') }}</button>
            </div>
        </div>
    </div>
</div>

</x-master-layout>
