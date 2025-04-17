<x-master-layout :assets="$assets ?? []">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">
                <div class="card card-block">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title mb-0">{{ __('message.riderequest') }}</h4>
                        </div>
                        <h4 class="float-right">#{{ $data->id }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <h4>{{ __('message.pickup_address') }}</h4>
                                <p>{{ $data->start_address }}</p>
                            </div>
                            <div class="col-6">
                                <h4>{{ __('message.drop_address') }}</h4>
                                <p>{{ $data->end_address }}</p>
                            </div>
                        </div>
                        @if(optional($data)->payment != null && optional($data)->payment->payment_status == 'paid')
                            <hr>
                            <div class="row">
                                <div class="col-4">
                                    <p>{{ __('message.total_distance') }}</p>
                                    {{ $data->distance }} {{ $data->distance_unit }}
                                </div>
                                <div class="col-4">
                                    <p>{{ __('message.total_duration') }}</p>
                                    {{ $data->duration }} {{ __('message.min') }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                
                {{-- cancellation reason --}}
                @if ($data->cancellation)    
                    <div class="card card-block">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title mb-0">Motivo de cancelación</h4>
                            </div>
                            {{-- <h4 class="float-right">#{{ $data->id }}</h4> --}}
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    {{-- <h4>Motivo</h4> --}}
                                    <p>{{ $data->cancellation->cancellationReason->name }}</p>
                                </div>

                            </div>
                        </div>
                    </div>
                @endif
                {{--  --}}

                <div class="card card-block">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title mb-0">
                                {{-- {{ __('message.map', [ 'form' => __('message.rider') ]) }} --}}
                                Mapa
                            </h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            
                            <div class="col-12">

                                <div id="map" style="height: 600px;"></div>
                                
                            </div>
                        </div>
                        
                    </div>
                </div>

                <div class="card card-block">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title mb-0">{{ __('message.payment') }}</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(optional($data)->payment != null && optional($data)->payment->payment_status == 'paid')
                            @php
                            $distance_unit = $data->distance_unit;
                            @endphp
                            <ul class="list-group list-group-flush">
                                {{-- <li class="list-group-item d-flex flex-xl-row flex-column justify-content-between align-items-center align-items-xl-start px-0">
                                    <span>{{ __('message.base_fare') }}</span>
                                    <span>{{ __('message.for_first') }} {{ $data->base_distance }} {{ __('message.'.$distance_unit) }}</span>
                                    <span class="">{{ getPriceFormat($data->base_fare) }}</span>
                                </li>
                                <li class="list-group-item d-flex flex-xl-row flex-column justify-content-between align-items-center align-items-xl-start px-0">
                                    <span>{{ __('message.distance') }}</span>
                                    @if($data->distance > $data->base_distance)
                                        <span>{{ $data->distance - $data->base_distance }} {{ $distance_unit }} x {{ $data->per_distance }}/{{ __('message.'.$distance_unit) }}</span>
                                    @else
                                        <span>{{ $data->distance }} {{ $distance_unit }} x {{ $data->per_distance }}/{{ __('message.'.$distance_unit) }}</span>
                                    @endif
                                    <span class="">{{ getPriceFormat($data->per_distance_charge) }}</span>
                                </li>
                                <li class="list-group-item d-flex flex-xl-row flex-column justify-content-between align-items-center align-items-xl-start px-0">
                                    <span>{{ __('message.duration') }}</span>
                                    <span>{{ $data->duration }} {{ __('message.min') }} x {{ $data->per_minute_drive }}/{{ __('message.min') }}</span>
                                    <span class="">{{ getPriceFormat($data->per_minute_drive_charge) }}</span>
                                </li>
                                <li class="list-group-item d-flex flex-xl-row flex-column justify-content-between align-items-center align-items-xl-start px-0">
                                    <span>{{ __('message.wait_time') }}</span>
                                    @if($data->waiting_time == 0)
                                        <span></span>
                                    @else
                                        <span>{{ $data->waiting_time }} {{ __('message.min') }} x {{ $data->per_minute_waiting }}/{{ __('message.min') }}</span>
                                    @endif
                                    <span class="">{{ getPriceFormat($data->per_minute_waiting_charge) }}</span>
                                </li>
                                <li class="list-group-item d-flex flex-xl-row flex-column justify-content-between align-items-center align-items-xl-start px-0">
                                    <span>{{ __('message.extra_charges') }}</span>
                                    @if(count($data->extra_charges) > 0)
                                        @php
                                            $extra_charges = collect($data->extra_charges)->pluck('key')->implode(', ');
                                        @endphp
                                        <span>{{ $extra_charges }}</span>
                                    @else
                                        <span></span>
                                    @endif
                                    <span class="">{{ getPriceFormat($data->extra_charges_amount) }}</span>
                                </li> --}}

                                <li class="list-group-item d-flex flex-xl-row flex-column justify-content-between align-items-center align-items-xl-start px-0">
                                    <span>{{ __('message.payment_method') }}</span>
                                    <span class="font-weight-bold">{{  trans("message.".$data->payment_type) ?? '-' }}</span>
                                </li>

                                <li class="list-group-item d-flex flex-xl-row flex-column justify-content-between align-items-center align-items-xl-start px-0">
                                    <span>{{ __('message.bid_rate') }}</span>
                                    <span></span>
                                    <span class="">{{ getPriceFormat($data->proposed_fee) }}</span>
                                </li>

                                <li class="list-group-item d-flex flex-xl-row flex-column justify-content-between align-items-center align-items-xl-start px-0">
                                    <span>{{ __('message.tip') }}</span>
                                    <span></span>
                                    <span class="">{{ getPriceFormat($data->tips) }}</span>
                                </li>
                                <li class="list-group-item d-flex flex-xl-row flex-column justify-content-between align-items-center align-items-xl-start px-0">
                                    <span>{{ __('message.coupon_discount') }}</span>
                                    <span></span>
                                    <span class="">{{ getPriceFormat($data->coupon_discount) }}</span>
                                </li>
                                <li class="list-group-item d-flex flex-xl-row flex-column justify-content-between align-items-center align-items-xl-start px-0">
                                    <span>{{ __('message.amount') }}</span>
                                    @php
                                        $total_amount = ( $data->tips ?? 0 ) + optional($data->payment)->total_amount;
                                    @endphp
                                    <span class="font-weight-bold">{{ getPriceFormat($total_amount) }}</span>
                                </li>
                            </ul>
                        @else
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex flex-xl-row flex-column justify-content-between align-items-center align-items-xl-start px-0">
                                    <span>{{ __('message.payment_method') }}</span>
                                    <span class="font-weight-bold">{{  trans("message.".$data->payment_type) ?? '-' }}</span>
                                </li>
                                <li class="list-group-item d-flex flex-xl-row flex-column justify-content-between align-items-center align-items-xl-start px-0">
                                    <span>{{ __('message.amount') }}</span>
                                    <span class="font-weight-bold">{{ optional($data->payment)->total_amount == null ? 'Sin pagar' : getPriceFormat(optional($data->payment)->total_amount) }}</span>
                                </li>
                            </ul>
                        @endif
                    </div>
                </div>
                @if(count($data->rideRequestHistory) > 0)
                    <div class="card card-block">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title mb-0">{{ __('message.activity_timeline') }}</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="mm-timeline0 m-0 d-flex align-items-center justify-content-between position-relative">
                                <ul class="list-inline p-0 m-0">

                                    @foreach($data->rideRequestHistory as $history)
                                        <li>
                                            <div class="timeline-dots1 border-primary text-primary">
                                                <!-- <i class="ri-login-circle-line"></i> -->
                                            </div>
                                            <h6 class="float-left mb-1">{{ __('message.'.$history->history_type) }}</h6>
                                            <small class="float-right mt-1">{{ $history->datetime }}</small>
                                            <div class="d-inline-block w-100">
                                                <p>{{ $history->history_message }}</p>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-lg-4">
                <div class="card card-block">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title mb-0">{{ __('message.detail_form_title', [ 'form' => __('message.rider') ]) }}</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3">
                                <img src="{{ getSingleMedia(optional($data->rider), 'profile_image',null) }}" alt="rider-profile" class="img-fluid avatar-60 rounded-small">
                            </div>
                            <div class="col-9">
                                <p class="mb-0">{{ optional($data->rider)->display_name }}</p>
                                <p class="mb-0">{{ optional($data->rider)->contact_number }}</p>
                                <p class="mb-0">{{ optional($data->rider)->email }}</p>
                                <p class="mb-0">{{ optional($data->rideRequestRiderRating())->rating }}
                                    @if( optional($data->rideRequestRiderRating())->rating > 0 )
                                        <i class="fa fa-star" style="color: yellow"></i>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                @if( isset($data->driver) )
                <div class="card card-block">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title mb-0">{{ __('message.detail_form_title', [ 'form' => __('message.driver') ]) }}</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3">
                                <img src="{{ getSingleMedia(optional($data->driver), 'profile_image',null) }}" alt="driver-profile" class="img-fluid avatar-60 rounded-small">
                            </div>
                            <div class="col-9">
                                <p class="mb-0">{{ optional($data->driver)->display_name }}</p>
                                <p class="mb-0">{{ optional($data->driver)->contact_number }}</p>
                                <p class="mb-0">{{ optional($data->driver)->email }}</p>
                                <p class="mb-0">{{ optional($data->rideRequestDriverRating())->rating }}
                                    @if( optional($data->rideRequestDriverRating())->rating > 0 )
                                        <i class="fa fa-star" style="color: yellow"></i>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

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
                            </div>
                        </div>
                    </div>
                    @if($data->status != 'completed')
                    <div class="card-footer">
                        <div class="">
                            <form
                                action="{{ route('riderequest.update', $data->id) }}"
                                method="post"
                                onsubmit="return confirm('¿Estás seguro de que quieres finalizar este viaje?')"
                            >
                                @csrf
                                @method('PUT')
{{--                                <input type="hidden" name="ride_request_id" value="{{ $data->id }}">--}}
                                <input type="hidden" name="status" value="completed">
                                <button type="submit" class="btn btn-danger" style="width: 100%">{{ __('message.end_ride') }}</button>
                            </form>
{{--                            <button type="submit" class="btn btn-danger" style="width: 100%">{{ __('message.end_ride') }}</button>--}}
                        </div>
                    </div>
                    @endif
                </div>

                <div class="card card-block">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title mb-0">{{ __('message.assign_driver', [ 'form' => __('message.service') ]) }}</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">

                                <form
                                    action="{{ route('riderequest.assign-driver') }}"
                                    method="post"
                                    onsubmit="return confirm('¿Estás seguro de asignar este conductor?')"
                                >

                                <select class="form-control select2js" name="driver_id" required>
                                    <option value="">Selecione...</option>
                                    @foreach($drivers as $driver)
                                        <option value="{{$driver->id}}" {{ $driver->id == $data->driver_id ? 'selected' : '' }}>
                                            {{ $driver->first_name }} {{ $driver->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    @if(!in_array($data->status, ['canceled', 'completed']))
                    <div class="card-footer">
                        <div class="">
                            @csrf
                            <input type="hidden" name="riderequest_id" value="{{$data->id}}">
                            <button type="submit" class="btn btn-success" style="width: 100%">
                                {{ __('message.assign') }}
                            </button>
                        </div>
                    </div>
                    @endif
                    </form>
                </div>

            </div>

            {{--  --}}

            {{-- <div class="col-lg-8">

            </div> --}}
        </div>
    </div>

    @section('bottom_script')
    <script>
        $(function(){
            let map;
            var marker = undefined;
            var driverMarker = undefined;
            var locations = [];
            var taxiicon = "";
            var driver = undefined;
            // $(document).ready( function() {
            //     driverList(); 
            // });
            function initialize() {
                var myLatlng = new google.maps.LatLng(6.423750, -66.589730);
                var myOptions = {
                    zoom: 5,
                    center: myLatlng,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                }
                map = new google.maps.Map(document.getElementById('map'), myOptions);
                const legend = document.getElementById("maplegend");

                map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(legend);

                let latlng1 = new google.maps.LatLng( parseFloat("{{ $data->start_latitude }}"), parseFloat("{{ $data->start_longitude }}"));
                let latlng2 = new google.maps.LatLng( parseFloat("{{ $data->end_latitude }}"), parseFloat("{{ $data->end_longitude }}"));
                let driverLatLng = undefined;

                let taxicon = "{{ asset('images/ontrip.png') }}";

                // Crear el servicio DirectionsService para solicitar la ruta
                let directionsService = new google.maps.DirectionsService();

                // Crear el DirectionsRenderer para mostrar la ruta en el mapa
                let directionsRenderer = new google.maps.DirectionsRenderer();
                directionsRenderer.setMap(map);

                initDrivePositionUpdate();

                // marker = new google.maps.Marker({
                //     position:  latlng1,
                //     // position:  new google.maps.LatLng( parseFloat("{{ $data->start_latitude }}") + (Math.random() -.5) / 1500, parseFloat("{{ $data->start_longitude }}") + (Math.random() -.5) / 1500 ),
                //     map: map,
                //     icon: taxicon,
                //     title: "Recogida",
                //     // driver_id: locations[i].id
                // });

                // taxicon = "{{ asset('images/online.png') }}";
                
                // marker = new google.maps.Marker({
                //     position:  latlng2,
                //     // position:  new google.maps.LatLng( parseFloat("{{ $data->end_latitude }}") + (Math.random() -.5) / 1500, parseFloat("{{ $data->end_longitude }}") + (Math.random() -.5) / 1500 ),
                //     map: map,
                //     icon: taxicon,
                //     title: "Destino",
                //     // driver_id: locations[i].id
                // });

                // Usar LatLngBounds para centrar el mapa en los dos marcadores
                let bounds = new google.maps.LatLngBounds();
                bounds.extend(latlng1);
                bounds.extend(latlng2);

                // Ajustar el mapa para que ambos marcadores estén visibles
                map.fitBounds(bounds);

                // Configuración para la solicitud de ruta
                var request = {
                    origin: latlng1,
                    destination: latlng2,
                    travelMode: google.maps.TravelMode.DRIVING // Puede ser DRIVING, BICYCLING, WALKING o TRANSIT
                };

                // Enviar la solicitud de ruta
                directionsService.route(request, function(result, status) {
                    if (status == google.maps.DirectionsStatus.OK) {
                        // Mostrar la ruta en el mapa
                        directionsRenderer.setDirections(result);
                    } else {
                        console.log('Error al obtener la ruta: ' + status);
                    }
                });
                
            }

            function changeMarkerPositions(locations)
            {
                var infowindow = new google.maps.InfoWindow();
                var markers = {};
                if(locations.length > 0 )
                {
                    for(i = 0 ; i < locations.length ; i++) {
                        // console.log("new "+locations[i].latitude, locations[i].longitude);
                    
                        if(markers[locations[i].id] ){
                            markers[locations[i].id].setMap(null); // set markers setMap to null to remove it from map
                            delete markers[locations[i].id]; // delete marker instance from markers object
                        }
                        
                        if( locations[i].is_online == 1 && locations[i].is_available == 0) {
                            taxicon = "{{ asset('images/ontrip.png') }}";
                        } else if( locations[i].is_online == 1 ) {
                            taxicon = "{{ asset('images/online.png') }}";
                        } else {
                            taxicon = "{{ asset('images/offline.png') }}";
                        }
                        marker = new google.maps.Marker({
                            position:  new google.maps.LatLng( parseFloat(locations[i].latitude)  + (Math.random() -.5) / 1500, parseFloat(locations[i].longitude) + (Math.random() -.5) / 1500 ),
                            map: map,
                            icon: taxicon,
                            title: locations[i].display_name,
                            driver_id: locations[i].id
                        });
                        marker.metadata= { id : locations[i].id };
                        
                        google.maps.event.addListener(marker, 'click', (function (marker, i) {
                            return function () {
                                driver = driverDetail(marker.driver_id);
                                service_name = driver.driver_service != null ? driver.driver_service.name : '-';
                                last_location_update_at = driver.last_location_update_at != null ? driver.last_location_update_at : '-';
                                driver_view = "{{ route('driver.show', '' ) }}/"+marker.driver_id;
                                contentString = '<div class="map_driver_detail"><ul class="list-unstyled mb-0">'+
                                '<li><i class="fa fa-address-card" aria-hidden="true"></i>: '+driver.display_name+'</li>'+
                                '<li><i class="fa fa-phone" aria-hidden="true"></i>: '+driver.contact_number+'</li>'+
                                '<li><i class="fa fa-taxi" aria-hidden="true"></i>: '+service_name+'</li>'+
                                '<li><i class="fa fa-clock" aria-hidden="true"></i>: '+last_location_update_at+'</li>'+
                                '<li><a href="'+driver_view+'"><i class="fa fa-eye" aria-hidden="true"></i> {{ __("message.view_form_title",[ "form" => __("message.driver") ]) }}</a></li>'+
                                '</ul></div>';
                                infowindow.setContent(contentString);
                                // infowindow.setContent(locations[i].display_name);
                                infowindow.open(map, marker);
                            }
                        })(marker, i));
                        markers[locations[i].id] = marker;
                    }
                }
            }

            function driverDetail(driver_id) {
                url = "{{ route('driverdetail',[ 'id' =>'']) }}"+driver_id;
                var driver_data;
                $.ajax({
                    type: 'get',
                    url: url,
                    async: false,
                    success: function(res) {
                        driver_data = res.data;
                    }
                });
                console.log(driver_data, 'driver data');
                return driver_data;
            }

            function initDrivePositionUpdate() {

                let driverId = "{{ $data->driver_id }}";
                let taxicon = "{{ asset('images/ontrip.png') }}";
                
                if (driverId) {

                    driver = driverDetail("{{ $data->driver_id }}");
                    driverLatLng = new google.maps.LatLng( parseFloat(driver.latitude), parseFloat(driver.longitude));

                    driverMarker = new google.maps.Marker({
                        position:  driverLatLng,
                        // position:  new google.maps.LatLng( parseFloat("{{ $data->start_latitude }}") + (Math.random() -.5) / 1500, parseFloat("{{ $data->start_longitude }}") + (Math.random() -.5) / 1500 ),
                        map: map,
                        icon: taxicon,
                        title: "Conductor",
                        // driver_id: locations[i].id
                    });

                    setInterval(() => {

                        driver = driverDetail("{{ $data->driver_id }}");
                        driverLatLng = new google.maps.LatLng( parseFloat(driver.latitude), parseFloat(driver.longitude));
                        driverMarker.setPosition(driverLatLng); // Actualizar la posición del marcador   
                        // map.setCenter(newPosition);                    
                        
                    }, 20 * 1000);

                }
                
            }

            // function driverList() {
            //     var url = "{{ route('driver_list.map') }}";
            //     $.ajax({
            //         type: 'get',
            //         url: url,
            //         success: function(res) {
            //             if(res.data.length > 0) {
            //                 changeMarkerPositions(res.data)
            //             }
            //         }
            //     });
            // }

            if(window.google || window.google.maps) {
                initialize();
                $('#maplegend').removeClass('d-none')
                // console.log('1.initial');
            }
        });
    </script>
@endsection

</x-master-layout>
