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
    <div class="modal-dialog modal-fullscreen-lg-down" role="document" style="max-width: 95%; margin: 20px auto;">
        <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
            <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px 15px 0 0; border: none; padding: 20px 25px;">
                <h5 class="modal-title text-white font-weight-bold" id="rideHistoryModalLabel" style="font-size: 1.3rem;">
                    <i class="fas fa-history mr-2"></i> {{ __('message.view_ride_history') }} - {{ $data->display_name }}
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 0.8; font-size: 1.5rem;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 25px;">
                <!-- Filtros -->
                <div class="row mb-4">
                    <div class="col-md-2">
                        <label for="fromDate" class="form-label font-weight-bold text-muted">Desde:</label>
                        <input type="date" class="form-control" id="fromDate" placeholder="Fecha inicial" style="border-radius: 8px; border: 1px solid #e3e6f0;">
                    </div>
                    <div class="col-md-2">
                        <label for="toDate" class="form-label font-weight-bold text-muted">Hasta:</label>
                        <input type="date" class="form-control" id="toDate" placeholder="Fecha final" style="border-radius: 8px; border: 1px solid #e3e6f0;">
                    </div>
                    <div class="col-md-2">
                        <label for="paymentType" class="form-label font-weight-bold text-muted">Método de Pago:</label>
                        <select class="form-control" id="paymentType" style="border-radius: 8px; border: 1px solid #e3e6f0;">
                            <option value="all">Todos</option>
                            <option value="cash">Efectivo</option>
                            <option value="wallet">Billetera</option>
                            <option value="mobile">Móvil</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label font-weight-bold text-muted">&nbsp;</label>
                        <div>
                            <button type="button" class="btn btn-primary btn-sm mr-2" onclick="applyFilters()" style="border-radius: 8px; padding: 8px 16px;">
                                <i class="fas fa-filter mr-1"></i> Filtrar
                            </button>
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="clearFilters()" style="border-radius: 8px; padding: 8px 16px;">
                                <i class="fas fa-times mr-1"></i> Limpiar
                            </button>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="perPage" class="form-label font-weight-bold text-muted">Registros por página:</label>
                        <select class="form-control" id="perPage" onchange="changePerPage()" style="border-radius: 8px; border: 1px solid #e3e6f0;">
                            <option value="10">10 por página</option>
                            <option value="25">25 por página</option>
                            <option value="50">50 por página</option>
                            <option value="100">100 por página</option>
                        </select>
                    </div>
                </div>

                <!-- Información de paginación -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <small class="text-muted font-weight-bold" id="paginationInfo">
                            Mostrando 0 de 0 registros
                        </small>
                    </div>
                    <div class="col-md-6 text-right">
                        <button type="button" class="btn btn-success btn-sm" onclick="exportToCSV()" style="border-radius: 8px; padding: 8px 16px;">
                            <i class="fas fa-download mr-1"></i> Exportar CSV
                        </button>
                    </div>
                </div>

                <!-- Tabla -->
                <div class="table-responsive" style="border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <table class="table table-bordered table-striped table-hover mb-0">
                        <thead style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                            <tr>
                                <th style="border: none; padding: 15px 8px; font-weight: 600; width: 80px; text-align: center;">ID</th>
                                <th style="border: none; padding: 15px 8px; font-weight: 600; width: 120px; text-align: center;">Fecha/Hora</th>
                                <th style="border: none; padding: 15px 8px; font-weight: 600; width: 150px; text-align: center;">Pasajero</th>
                                <th style="border: none; padding: 15px 8px; font-weight: 600; width: 100px; text-align: center;">Monto</th>
                                <th style="border: none; padding: 15px 8px; font-weight: 600; width: 120px; text-align: center;">Método</th>
                                <th style="border: none; padding: 15px 8px; font-weight: 600; width: 120px; text-align: center;">Efectivo Recibido</th>
                                <th style="border: none; padding: 15px 8px; font-weight: 600; width: 120px; text-align: center;">Efectivo Cobrado</th>
                                <th style="border: none; padding: 15px 8px; font-weight: 600; width: 100px; text-align: center;">Vuelto</th>
                                <th style="border: none; padding: 15px 8px; font-weight: 600; width: 120px; text-align: center;">Saldo Billetera</th>
                                <th style="border: none; padding: 15px 8px; font-weight: 600; width: 100px; text-align: center;">Estado</th>
                                <th style="border: none; padding: 15px 8px; font-weight: 600; width: 80px; text-align: center;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Los datos se cargarán dinámicamente via AJAX -->
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <nav aria-label="Paginación del historial">
                            <ul class="pagination pagination-sm justify-content-center" id="pagination">
                                <!-- La paginación se generará dinámicamente -->
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="border-top: 1px solid #e3e6f0; padding: 20px 25px; border-radius: 0 0 15px 15px;">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border-radius: 8px; padding: 8px 20px;">{{ __('message.close') }}</button>
            </div>
        </div>
    </div>
</div>

<script>
console.log('=== SCRIPT LOADED ===');

// Variables globales para el estado
let currentPage = 1;
let currentFilters = {
    from_date: '',
    to_date: '',
    payment_type: 'all',
    per_page: 10
};

// Función para esperar a que jQuery esté disponible
function waitForJQuery(callback) {
    if (typeof $ !== 'undefined') {
        console.log('jQuery is available, executing callback');
        callback();
    } else {
        console.log('jQuery not available yet, waiting...');
        setTimeout(function() {
            waitForJQuery(callback);
        }, 100);
    }
}

// Esperar a que jQuery esté disponible
waitForJQuery(function() {
    console.log('jQuery available:', typeof $ !== 'undefined');
    console.log('jQuery version:', typeof $ !== 'undefined' ? $.fn.jquery : 'not available');

    $(document).ready(function() {
        console.log('Document ready - Setting up modal event');

        // Verificar que el modal existe
        const modal = $('#rideHistoryModal');
        console.log('Modal found:', modal.length > 0);

        // Verificar que el botón existe y agregar evento click
        const button = $('button[data-target="#rideHistoryModal"]');
        console.log('Button found:', button.length > 0);

        button.on('click', function() {
            console.log('Button clicked!');
        });

        // Evento que se dispara cuando el modal se abre
        $('#rideHistoryModal').on('show.bs.modal', function () {
            console.log('Modal show event triggered (before opening)');
        });

        // Evento que se dispara cuando el modal está completamente abierto
        $('#rideHistoryModal').on('shown.bs.modal', function () {
            console.log('Modal shown event triggered (after opening)');
            loadRideHistoryData();
        });

        console.log('Modal event listeners attached');
    });
});

function loadRideHistoryData(page = 1) {
    const driverId = {{ $data->id }};
    currentPage = page;

    console.log('loadRideHistoryData called with driver ID:', driverId, 'page:', page);

    // Mostrar loading en la tabla
    $('#rideHistoryModal tbody').html('<tr><td colspan="11" class="text-center"><i class="fas fa-spinner fa-spin"></i> Cargando historial de viajes...</td></tr>');

    // Construir URL con parámetros
    const params = new URLSearchParams({
        page: page,
        per_page: currentFilters.per_page
    });

    if (currentFilters.from_date) params.append('from_date', currentFilters.from_date);
    if (currentFilters.to_date) params.append('to_date', currentFilters.to_date);
    if (currentFilters.payment_type && currentFilters.payment_type !== 'all') {
        params.append('payment_type', currentFilters.payment_type);
    }

    const url = `/driver/${driverId}/ride-history?${params.toString()}`;
    console.log('Requesting URL:', url);

    // Hacer llamada AJAX
    $.ajax({
        url: url,
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            console.log('AJAX Success - Full response:', response);

            if (response.status && response.data) {
                renderRideHistoryTable(response.data);
                renderPagination(response.pagination);
                updatePaginationInfo(response.pagination);
            } else {
                $('#rideHistoryModal tbody').html('<tr><td colspan="11" class="text-center">No hay viajes completados.</td></tr>');
                $('#pagination').html('');
                $('#paginationInfo').text('No hay registros');
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error - Status:', status);
            console.error('AJAX Error - Error:', error);
            console.error('AJAX Error - Response:', xhr.responseText);

            $('#rideHistoryModal tbody').html('<tr><td colspan="11" class="text-center text-danger">Error al cargar datos. Intente nuevamente.</td></tr>');
        }
    });
}

function renderRideHistoryTable(rides) {
    console.log('renderRideHistoryTable called with rides:', rides);

    if (!rides || rides.length === 0) {
        $('#rideHistoryModal tbody').html('<tr><td colspan="11" class="text-center">No hay viajes completados.</td></tr>');
        return;
    }

    let html = '';
    rides.forEach(function(ride, index) {
        console.log(`Processing ride ${index}:`, ride);

        const rideDate = new Date(ride.datetime);
        const formattedDate = rideDate.toLocaleDateString('es-ES') + ' ' + rideDate.toLocaleTimeString('es-ES', {hour: '2-digit', minute:'2-digit'});

        const paymentTypeBadge = getPaymentTypeBadge(ride.payment_type);
        const collectedCash = ride.payment && ride.payment.collected_cash ? parseFloat(ride.payment.collected_cash).toFixed(2) : '-';
        const totalAmount = ride.payment && ride.payment.total_amount ? parseFloat(ride.payment.total_amount).toFixed(2) : '-';
        const change = calculateChange(ride.payment);
        const walletBalance = ride.historical_wallet_balance ? parseFloat(ride.historical_wallet_balance).toFixed(2) : '-';

        html += `
            <tr>
                <td><span class="badge" style="background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%); color: white; padding: 6px 12px; border-radius: 20px; font-size: 0.8rem;">#${ride.id}</span></td>
                <td><i class="fas fa-calendar-alt text-muted"></i> ${formattedDate}</td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm mr-2">
                            <i class="fas fa-user-circle fa-2x text-primary"></i>
                        </div>
                        <div>
                            <strong>${ride.rider ? (ride.rider.first_name || '-') + ' ' + (ride.rider.last_name || '') : '-'}</strong><br>
                            <small class="text-muted"><i class="fas fa-phone"></i> ${ride.rider ? (ride.rider.contact_number || '-') : '-'}</small>
                        </div>
                    </div>
                </td>
                <td><span class="badge" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; padding: 8px 16px; border-radius: 20px; font-size: 0.9rem; font-weight: bold;">$${parseFloat(ride.total_amount).toFixed(2)}</span></td>
                <td>${paymentTypeBadge}</td>
                <td class="text-success font-weight-bold">${collectedCash !== '-' ? '$' + collectedCash : '-'}</td>
                <td class="text-info font-weight-bold">${totalAmount !== '-' ? '$' + totalAmount : '-'}</td>
                <td class="text-warning font-weight-bold">${change}</td>
                <td class="text-primary font-weight-bold">${walletBalance !== '-' ? '$' + walletBalance : '-'}</td>
                <td><span class="badge" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; padding: 6px 12px; border-radius: 20px; font-size: 0.8rem;"><i class="fas fa-check mr-1"></i> Completada</span></td>
                <td>
                    <button class="btn btn-info btn-sm" onclick="viewRideDetails(${ride.id})" style="border-radius: 8px; padding: 6px 12px;">
                        <i class="fa fa-eye mr-1"></i> Ver
                    </button>
                </td>
            </tr>
        `;
    });

    $('#rideHistoryModal tbody').html(html);
}

function renderPagination(pagination) {
    if (!pagination || pagination.last_page <= 1) {
        $('#pagination').html('');
        return;
    }

    let html = '';

    // Botón anterior
    if (pagination.current_page > 1) {
        html += `<li class="page-item"><a class="page-link" href="#" onclick="loadRideHistoryData(${pagination.current_page - 1})" style="border-radius: 8px; margin: 0 2px; border: 1px solid #e3e6f0; color: #667eea;">Anterior</a></li>`;
    }

    // Páginas
    const startPage = Math.max(1, pagination.current_page - 2);
    const endPage = Math.min(pagination.last_page, pagination.current_page + 2);

    for (let i = startPage; i <= endPage; i++) {
        const activeClass = i === pagination.current_page ? 'active' : '';
        const activeStyle = i === pagination.current_page ?
            'background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-color: #667eea; color: white;' :
            'border: 1px solid #e3e6f0; color: #667eea;';

        html += `<li class="page-item ${activeClass}"><a class="page-link" href="#" onclick="loadRideHistoryData(${i})" style="border-radius: 8px; margin: 0 2px; ${activeStyle}">${i}</a></li>`;
    }

    // Botón siguiente
    if (pagination.current_page < pagination.last_page) {
        html += `<li class="page-item"><a class="page-link" href="#" onclick="loadRideHistoryData(${pagination.current_page + 1})" style="border-radius: 8px; margin: 0 2px; border: 1px solid #e3e6f0; color: #667eea;">Siguiente</a></li>`;
    }

    $('#pagination').html(html);
}

function updatePaginationInfo(pagination) {
    if (!pagination) {
        $('#paginationInfo').text('No hay registros');
        return;
    }

    const text = `Mostrando ${pagination.from || 0} a ${pagination.to || 0} de ${pagination.total} registros`;
    $('#paginationInfo').text(text);
}

function applyFilters() {
    currentFilters.from_date = $('#fromDate').val();
    currentFilters.to_date = $('#toDate').val();
    currentFilters.payment_type = $('#paymentType').val();
    currentFilters.per_page = $('#perPage').val();

    console.log('Applying filters:', currentFilters);
    loadRideHistoryData(1); // Reset to first page
}

function clearFilters() {
    $('#fromDate').val('');
    $('#toDate').val('');
    $('#paymentType').val('all');
    $('#perPage').val('10');

    currentFilters = {
        from_date: '',
        to_date: '',
        payment_type: 'all',
        per_page: 10
    };

    console.log('Clearing filters');
    loadRideHistoryData(1);
}

function changePerPage() {
    currentFilters.per_page = $('#perPage').val();
    loadRideHistoryData(1);
}

function getPaymentTypeBadge(paymentType) {
    switch(paymentType) {
        case 'cash':
            return '<span class="badge" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; padding: 6px 12px; border-radius: 20px; font-size: 0.8rem;"><i class="fas fa-money-bill-wave mr-1"></i> Efectivo</span>';
        case 'wallet':
            return '<span class="badge" style="background: linear-gradient(135deg, #007bff 0%, #6610f2 100%); color: white; padding: 6px 12px; border-radius: 20px; font-size: 0.8rem;"><i class="fas fa-wallet mr-1"></i> Billetera</span>';
        case 'mobile':
            return '<span class="badge" style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); color: white; padding: 6px 12px; border-radius: 20px; font-size: 0.8rem;"><i class="fas fa-mobile-alt mr-1"></i> Móvil</span>';
        default:
            return '<span class="badge" style="background: linear-gradient(135deg, #6c757d 0%, #495057 100%); color: white; padding: 6px 12px; border-radius: 20px; font-size: 0.8rem;"><i class="fas fa-credit-card mr-1"></i> ' + (paymentType ? paymentType.charAt(0).toUpperCase() + paymentType.slice(1) : 'N/A') + '</span>';
    }
}

function calculateChange(payment) {
    if (payment && payment.collected_cash && payment.total_amount) {
        const change = parseFloat(payment.collected_cash) - parseFloat(payment.total_amount);
        return '$' + change.toFixed(2);
    }
    return '-';
}

function viewRideDetails(rideId) {
    // Aquí puedes implementar la lógica para ver detalles del viaje
    alert('Ver detalles del viaje #' + rideId);
}

function exportToCSV() {
    const driverId = {{ $data->id }};

    console.log('Exporting CSV for driver ID:', driverId);
    console.log('Current filters:', currentFilters);

    // Construir URL con parámetros de filtro
    const params = new URLSearchParams();

    if (currentFilters.from_date) params.append('from_date', currentFilters.from_date);
    if (currentFilters.to_date) params.append('to_date', currentFilters.to_date);
    if (currentFilters.payment_type && currentFilters.payment_type !== 'all') {
        params.append('payment_type', currentFilters.payment_type);
    }

    const url = `/driver/${driverId}/ride-history/export?${params.toString()}`;
    console.log('Export URL:', url);

    // Crear un enlace temporal y hacer clic en él para descargar
    const link = document.createElement('a');
    link.href = url;
    link.download = '';
    link.style.display = 'none';

    // Agregar el enlace al DOM
    document.body.appendChild(link);

    // Hacer clic en el enlace
    link.click();

    // Remover el enlace del DOM
    document.body.removeChild(link);

    // Mostrar mensaje de éxito
    showExportSuccess();
}

function showExportSuccess() {
    // Crear un toast o notificación de éxito
    const toast = document.createElement('div');
    toast.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        padding: 15px 20px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 9999;
        font-weight: bold;
        animation: slideIn 0.3s ease-out;
    `;
    toast.innerHTML = '<i class="fas fa-check-circle mr-2"></i> CSV exportado exitosamente';

    // Agregar estilos de animación
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
    `;
    document.head.appendChild(style);

    document.body.appendChild(toast);

    // Remover después de 3 segundos
    setTimeout(() => {
        if (toast.parentNode) {
            toast.parentNode.removeChild(toast);
        }
        if (style.parentNode) {
            style.parentNode.removeChild(style);
        }
    }, 3000);
}
</script>

</x-master-layout>
