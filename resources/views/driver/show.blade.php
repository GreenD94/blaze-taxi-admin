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
                        <label for="fromDate" class="form-label font-weight-bold text-muted">{{ __('message.ride_history_filters.from') }}</label>
                        <input type="date" class="form-control" id="fromDate" placeholder="{{ __('message.ride_history_filters.from') }}" style="border-radius: 8px; border: 1px solid #e3e6f0;">
                    </div>
                    <div class="col-md-2">
                        <label for="toDate" class="form-label font-weight-bold text-muted">{{ __('message.ride_history_filters.to') }}</label>
                        <input type="date" class="form-control" id="toDate" placeholder="{{ __('message.ride_history_filters.to') }}" style="border-radius: 8px; border: 1px solid #e3e6f0;">
                    </div>
                    <div class="col-md-2">
                        <label for="paymentType" class="form-label font-weight-bold text-muted">{{ __('message.ride_history_filters.payment_type') }}</label>
                        <select class="form-control" id="paymentType" style="border-radius: 8px; border: 1px solid #e3e6f0;">
                            <option value="all">{{ __('message.ride_history_filters.all') }}</option>
                            <option value="cash">{{ __('message.ride_history_filters.cash') }}</option>
                            <option value="wallet">{{ __('message.ride_history_filters.wallet') }}</option>
                            <option value="mobile">{{ __('message.ride_history_filters.mobile') }}</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label font-weight-bold text-muted">&nbsp;</label>
                        <div>
                            <button type="button" class="btn btn-primary btn-sm mr-2" onclick="applyFilters()" style="border-radius: 8px; padding: 8px 16px;">
                                <i class="fas fa-filter mr-1"></i> {{ __('message.ride_history_filters.filter') }}
                            </button>
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="clearFilters()" style="border-radius: 8px; padding: 8px 16px;">
                                <i class="fas fa-times mr-1"></i> {{ __('message.ride_history_filters.clear') }}
                            </button>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="perPage" class="form-label font-weight-bold text-muted">{{ __('message.ride_history_filters.per_page') }}</label>
                        <select class="form-control" id="perPage" onchange="changePerPage()" style="border-radius: 8px; border: 1px solid #e3e6f0;">
                            <option value="10">10 {{ __('message.ride_history_filters.per_page') }}</option>
                            <option value="25">25 {{ __('message.ride_history_filters.per_page') }}</option>
                            <option value="50">50 {{ __('message.ride_history_filters.per_page') }}</option>
                            <option value="100">100 {{ __('message.ride_history_filters.per_page') }}</option>
                        </select>
                    </div>
                </div>

                <!-- Información de paginación -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <small class="text-muted font-weight-bold" id="paginationInfo">
                            {{ __('message.pagination.showing', ['from' => 0, 'to' => 0, 'total' => 0]) }}
                        </small>
                    </div>
                    <div class="col-md-6 text-right">
                        <button type="button" class="btn btn-success btn-sm" onclick="exportToCSV()" style="border-radius: 8px; padding: 8px 16px;">
                            <i class="fas fa-download mr-1"></i> {{ __('message.ride_history_filters.export_csv') }}
                        </button>
                    </div>
                </div>

                <!-- Tabla -->
                <div class="table-responsive" style="border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <table class="table table-bordered table-striped table-hover mb-0">
                        <thead style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                            <tr>
                                <th style="border: none; padding: 15px 8px; font-weight: 600; width: 80px; text-align: center;">{{ __('message.ride_history_table.id') }}</th>
                                <th style="border: none; padding: 15px 8px; font-weight: 600; width: 120px; text-align: center;">{{ __('message.ride_history_table.datetime') }}</th>
                                <th style="border: none; padding: 15px 8px; font-weight: 600; width: 150px; text-align: center;">{{ __('message.ride_history_table.rider') }}</th>
                                <th style="border: none; padding: 15px 8px; font-weight: 600; width: 100px; text-align: center;">{{ __('message.ride_history_table.amount') }}</th>
                                <th style="border: none; padding: 15px 8px; font-weight: 600; width: 120px; text-align: center;">{{ __('message.ride_history_table.method') }}</th>
                                <th style="border: none; padding: 15px 8px; font-weight: 600; width: 120px; text-align: center;">{{ __('message.ride_history_table.total_amount') }}</th>
                                <th style="border: none; padding: 15px 8px; font-weight: 600; width: 100px; text-align: center;">{{ __('message.ride_history_table.change') }}</th>
                                <th style="border: none; padding: 15px 8px; font-weight: 600; width: 120px; text-align: center;">{{ __('message.ride_history_table.wallet_balance') }}</th>
                                <th style="border: none; padding: 15px 8px; font-weight: 600; width: 100px; text-align: center;">{{ __('message.ride_history_table.status') }}</th>
                                <th style="border: none; padding: 15px 8px; font-weight: 600; width: 80px; text-align: center;">{{ __('message.ride_history_table.actions') }}</th>
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
// Configuración de la aplicación
const RideHistoryApp = {
    driverId: {{ $data->id }},
    currentPage: 1,
    currentFilters: {
        from_date: '',
        to_date: '',
        payment_type: 'all',
        per_page: 10
    },

    // Constantes para tipos de pago
    PAYMENT_TYPES: {
        CASH: 'cash',
        WALLET: 'wallet',
        MOBILE: 'mobile'
    },

    // URLs de la API
    API_URLS: {
        RIDE_HISTORY: '{{ route("driver.ride-history", $data->id) }}',
        EXPORT_CSV: '{{ route("driver.ride-history.export", $data->id) }}'
    },

    // Inicialización
    init() {
        this.waitForJQuery(() => {
            this.setupEventListeners();
            console.log('RideHistoryApp initialized successfully');
        });
    },

    // Esperar a que jQuery esté disponible
    waitForJQuery(callback) {
        if (typeof $ !== 'undefined') {
            callback();
        } else {
            setTimeout(() => this.waitForJQuery(callback), 100);
        }
    },

    // Configurar event listeners
    setupEventListeners() {
        $(document).ready(() => {
            // Evento cuando el modal se abre completamente
            $('#rideHistoryModal').on('shown.bs.modal', () => {
                this.loadRideHistoryData();
            });
        });
    },

    // Cargar datos del historial
    loadRideHistoryData(page = 1) {
        this.currentPage = page;
        this.showLoading();

        const params = new URLSearchParams({
            page: page,
            per_page: this.currentFilters.per_page,
            from_date: this.currentFilters.from_date,
            to_date: this.currentFilters.to_date,
            payment_type: this.currentFilters.payment_type
        });

        $.ajax({
            url: `${this.API_URLS.RIDE_HISTORY}?${params}`,
            method: 'GET',
            success: (response) => {
                if (response.status) {
                    this.renderTable(response.data);
                    this.renderPagination(response.pagination);
                    this.updatePaginationInfo(response.pagination);
                } else {
                    this.showError('Error al cargar los datos');
                }
            },
            error: (xhr, status, error) => {
                console.error('Error loading ride history:', error);
                this.showError('Error al cargar el historial de viajes');
            }
        });
    },

    // Mostrar loading
    showLoading() {
        $('#rideHistoryModal tbody').html(`
            <tr>
                <td colspan="10" class="text-center">
                    <i class="fas fa-spinner fa-spin"></i> Cargando historial de viajes...
                </td>
            </tr>
        `);
    },

    // Mostrar error
    showError(message) {
        $('#rideHistoryModal tbody').html(`
            <tr>
                <td colspan="10" class="text-center text-danger">
                    <i class="fas fa-exclamation-triangle"></i> ${message}
                </td>
            </tr>
        `);
    },

    // Renderizar tabla
    renderTable(data) {
        if (!data || data.length === 0) {
            $('#rideHistoryModal tbody').html(`
                <tr>
                    <td colspan="10" class="text-center text-muted">
                        <i class="fas fa-info-circle"></i> No se encontraron registros
                    </td>
                </tr>
            `);
            return;
        }

        const tbody = $('#rideHistoryModal tbody');
        tbody.empty();

        data.forEach(ride => {
            const row = this.createTableRow(ride);
            tbody.append(row);
        });
    },

    // Crear fila de tabla
    createTableRow(ride) {
        const paymentTypeLabel = this.getPaymentTypeLabel(ride.payment_type);
        const paymentTypeStyle = this.getPaymentTypeStyle(ride.payment_type);

        return `
            <tr>
                <td class="text-center">${ride.id}</td>
                <td class="text-center">${ride.formatted_datetime}</td>
                <td>
                    <div class="font-weight-bold">${ride.rider.full_name || '-'}</div>
                    <small class="text-muted">${ride.rider.contact_number || '-'}</small>
                </td>
                <td class="text-center font-weight-bold text-success">
                    $${ride.formatted_total_amount}
                </td>
                <td class="text-center">
                    <span class="badge" style="${paymentTypeStyle}">
                        ${paymentTypeLabel}
                    </span>
                </td>
                <td class="text-center">${ride.payment.formatted_total_amount || '-'}</td>
                <td class="text-center">${ride.payment.formatted_change || '-'}</td>
                <td class="text-center">${ride.formatted_historical_wallet_balance || '-'}</td>
                <td class="text-center">
                    <span class="badge badge-success">Completada</span>
                </td>
                <td class="text-center">
                    <button class="btn btn-sm btn-outline-info" onclick="RideHistoryApp.viewRideDetails(${ride.id})" title="Ver detalles">
                        <i class="fas fa-eye"></i>
                    </button>
                </td>
            </tr>
        `;
    },

    // Obtener etiqueta del tipo de pago
    getPaymentTypeLabel(paymentType) {
        const labels = {
            [this.PAYMENT_TYPES.CASH]: 'Efectivo',
            [this.PAYMENT_TYPES.WALLET]: 'Billetera',
            [this.PAYMENT_TYPES.MOBILE]: 'Móvil',
            'mobile-payment': 'Pago Móvil'
        };
        return labels[paymentType] || paymentType;
    },

    // Obtener estilo del tipo de pago
    getPaymentTypeStyle(paymentType) {
        const styles = {
            [this.PAYMENT_TYPES.CASH]: 'background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white;',
            [this.PAYMENT_TYPES.WALLET]: 'background: linear-gradient(135deg, #007bff 0%, #6610f2 100%); color: white;',
            [this.PAYMENT_TYPES.MOBILE]: 'background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); color: white;',
            'mobile-payment': 'background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); color: white;'
        };
        return styles[paymentType] || 'background: #6c757d; color: white;';
    },

    // Renderizar paginación
    renderPagination(pagination) {
        const paginationContainer = $('#pagination');
        paginationContainer.empty();

        if (pagination.last_page <= 1) return;

        // Botón anterior
        const prevDisabled = pagination.current_page === 1 ? 'disabled' : '';
        paginationContainer.append(`
            <li class="page-item ${prevDisabled}">
                <a class="page-link" href="#" onclick="RideHistoryApp.loadRideHistoryData(${pagination.current_page - 1})">
                    <i class="fas fa-chevron-left"></i>
                </a>
            </li>
        `);

        // Números de página
        for (let i = 1; i <= pagination.last_page; i++) {
            const active = i === pagination.current_page ? 'active' : '';
            paginationContainer.append(`
                <li class="page-item ${active}">
                    <a class="page-link" href="#" onclick="RideHistoryApp.loadRideHistoryData(${i})">${i}</a>
                </li>
            `);
        }

        // Botón siguiente
        const nextDisabled = pagination.current_page === pagination.last_page ? 'disabled' : '';
        paginationContainer.append(`
            <li class="page-item ${nextDisabled}">
                <a class="page-link" href="#" onclick="RideHistoryApp.loadRideHistoryData(${pagination.current_page + 1})">
                    <i class="fas fa-chevron-right"></i>
                </a>
            </li>
        `);
    },

    // Actualizar información de paginación
    updatePaginationInfo(pagination) {
        const info = `Mostrando ${pagination.from || 0} a ${pagination.to || 0} de ${pagination.total || 0} registros`;
        $('#paginationInfo').text(info);
    },

    // Aplicar filtros
    applyFilters() {
        this.currentFilters.from_date = $('#fromDate').val();
        this.currentFilters.to_date = $('#toDate').val();
        this.currentFilters.payment_type = $('#paymentType').val();
        this.currentFilters.per_page = parseInt($('#perPage').val());

        this.loadRideHistoryData(1);
    },

    // Limpiar filtros
    clearFilters() {
        $('#fromDate').val('');
        $('#toDate').val('');
        $('#paymentType').val('all');
        $('#perPage').val('10');

        this.currentFilters = {
            from_date: '',
            to_date: '',
            payment_type: 'all',
            per_page: 10
        };

        this.loadRideHistoryData(1);
    },

    // Cambiar registros por página
    changePerPage() {
        this.currentFilters.per_page = parseInt($('#perPage').val());
        this.loadRideHistoryData(1);
    },

    // Exportar a CSV
    exportToCSV() {
        const params = new URLSearchParams({
            from_date: this.currentFilters.from_date,
            to_date: this.currentFilters.to_date,
            payment_type: this.currentFilters.payment_type
        });

        const url = `${this.API_URLS.EXPORT_CSV}?${params}`;

        // Crear un enlace temporal para descargar
        const link = document.createElement('a');
        link.href = url;
        link.download = '';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);

        // Mostrar notificación de éxito
        this.showNotification('CSV exportado exitosamente', 'success');
    },

    // Ver detalles del viaje
    viewRideDetails(rideId) {
        // Aquí puedes implementar la lógica para mostrar detalles del viaje
        console.log('Ver detalles del viaje:', rideId);
        this.showNotification('Función de detalles próximamente disponible', 'info');
    },

    // Mostrar notificación
    showNotification(message, type = 'info') {
        const alertClass = type === 'success' ? 'alert-success' :
                          type === 'error' ? 'alert-danger' :
                          type === 'warning' ? 'alert-warning' : 'alert-info';

        const alert = $(`
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : type === 'warning' ? 'exclamation-triangle' : 'info-circle'}"></i>
                ${message}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        `);

        $('body').append(alert);

        // Auto-remover después de 5 segundos
        setTimeout(() => {
            alert.alert('close');
        }, 5000);
    }
};

// Funciones globales para compatibilidad con el HTML
function applyFilters() {
    RideHistoryApp.applyFilters();
}

function clearFilters() {
    RideHistoryApp.clearFilters();
}

function changePerPage() {
    RideHistoryApp.changePerPage();
}

function exportToCSV() {
    RideHistoryApp.exportToCSV();
}

// Inicializar la aplicación cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    RideHistoryApp.init();
});
</script>

</x-master-layout>
