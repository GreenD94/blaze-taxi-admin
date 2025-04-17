<x-master-layout :assets="$assets ?? []">
    <div>
        <?php $id = $id ?? null; ?>
        @if (isset($id))
            {!! Form::model($data, [
                'route' => ['bonus.update', $id],
                'method' => 'patch',
                'enctype' => 'multipart/form-data',
            ]) !!}
        @else
            {!! Form::open(['route' => ['bonus.store'], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
        @endif
        <div class="row">
            <div class="col-xl-3 col-lg-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">{{ $pageTitle }}</h4>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="form-group">
                            <label class="form-label">{{ __('message.status') }}</label>
                            <div class="grid" style="--bs-gap: 1rem">
                                <div class="form-check g-col-6">
                                    {{ Form::radio('status', 'active', old('status') || true, ['class' => 'form-check-input', 'id' => 'status-active']) }}
                                    {{ Form::label('status-active', __('message.active'), ['class' => 'form-check-label']) }}
                                </div>
                                <div class="form-check g-col-6">
                                    {{ Form::radio('status', 'inactive', old('status'), ['class' => 'form-check-input', 'id' => 'status-inactive']) }}
                                    {{ Form::label('status-inactive', __('message.inactive'), ['class' => 'form-check-label']) }}
                                </div>
                                {{-- <div class="form-check g-col-6">
                                    {{ Form::radio('status', 'pending', old('status'), ['class' => 'form-check-input', 'id' => 'status-pending']) }}
                                    {{ Form::label('status-pending', __('message.pending'), ['class' => 'form-check-label']) }}
                                </div>
                                <div class="form-check g-col-6">
                                    {{ Form::radio('status', 'banned', old('status'), ['class' => 'form-check-input', 'id' => 'status-banned']) }}
                                    {{ Form::label('status-banned', __('message.banned'), ['class' => 'form-check-label']) }}
                                </div>
                                <div class="form-check g-col-6">
                                    {{ Form::radio('status', 'reject', old('status'), ['class' => 'form-check-input', 'id' => 'status-reject']) }}
                                    {{ Form::label('status-reject', __('message.reject'), ['class' => 'form-check-label']) }}
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">{{ $pageTitle }} {{ __('message.information') }}</h4>
                        </div>
                        <div class="card-action">
                            <a href="{{ route('bonus.index') }}" class="btn btn-sm btn-primary"
                                role="button">{{ __('message.back') }}</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="new-user-info">
                            <div class="row">

                                <div class="form-group col-md-6">
                                    {{ Form::label('name', __('message.name') . ' <span class="text-danger">*</span>', ['class' => 'form-control-label'], false) }}
                                    {{ Form::text('name', old('name'), ['placeholder' => __('message.name'), 'class' => 'form-control', 'required', 'minlength' => 3]) }}
                                </div>

                                {{-- <div class="form-group col-md-6">
                                    {{ Form::label('description',__('message.description').' <span class="text-danger">*</span>',['class'=>'form-control-label'], false ) }}
                                    {{ Form::textarea('description',old('description'),['placeholder' => __('message.description'),'class' =>'form-control textarea', 'rows'=>3]) }}
                                </div> --}}

                                <div class="form-group col-md-6">
                                    {{ Form::label('rides_qty', __('message.rides_qty') . ' <span class="text-danger">*</span>', ['class' => 'form-control-label'], false) }}
                                    {{ Form::number('rides_qty', old('rides_qty'), ['placeholder' => __('message.rides_qty'), 'class' => 'form-control', 'required', 'min' => 1, 'step' => 1]) }}
                                </div>

                                <div class="form-group col-md-6">
                                    {{ Form::label('amount', __('message.amount') . ' <span class="text-danger">*</span>', ['class' => 'form-control-label'], false) }}
                                    {{ Form::number('amount', old('amount'), ['placeholder' => __('message.amount'), 'class' => 'form-control', 'required', 'min' => 1, 'step' => 0.01]) }}
                                </div>

                                <div class="form-group col-md-6">

                                </div>

                                <div class="form-group col-md-6">

                                    <label class="form-label">{{ __('message.starts_at') }}</label>
                                    <div class="grid" style="--bs-gap: 1rem">

                                        <div class="form-check">
                                            {{ Form::radio('start_date_type', 'fixed', old('start_date_type') || true, ['class' => 'form-check-input', 'id' => 'fixed']) }}
                                            {{ Form::label('fixed', __('message.fixed_date'), ['class' => 'form-check-label']) }}
                                        </div>

                                        <div class="form-check">
                                            {{ Form::radio('start_date_type', 'verification_date', old('start_date_type') || false, ['class' => 'form-check-input', 'id' => 'verified-date']) }}
                                            {{ Form::label('verified-date', __('message.verification_date'), ['class' => 'form-check-label']) }}
                                        </div>

                                        <br>

                                        {{ Form::date('starts_at', $data->starts_at ?? \Carbon\Carbon::now(), ['id' => 'starts_at']) }}
                                    </div>

                                </div>

                                <div class="form-group col-md-6">

                                    <label class="form-label">{{ __('message.ends_at') }}</label>

                                    <div class="grid" style="--bs-gap: 1rem">

                                        <div class="form-check">
                                            {{ Form::radio('end_date_type', 'days_to_expiration', old('end_date_type') || true, ['class' => 'form-check-input', 'id' => 'ends-fixed']) }}
                                            {{ Form::label('ends-fixed', __('message.days_to_expiration'), ['class' => 'form-check-label']) }}
                                        </div>

                                        <div class="form-check">
                                            {{ Form::radio('end_date_type', 'fixed', old('end_date_type') || false, ['class' => 'form-check-input', 'id' => 'ends-verification-date']) }}
                                            {{ Form::label('ends-verification-date', __('message.fixed_date'), ['class' => 'form-check-label']) }}
                                        </div>

                                        <br>

                                        <div class="form-group" id="days-to-expiration">
                                            {{ Form::label('days_to_expiration', __('message.days_to_expiration') . ' <span class="text-danger">*</span>', ['class' => 'form-control-label'], false) }}
                                            {{ Form::number('days_to_expiration', old('rides_qty'), ['placeholder' => __('message.days_to_expiration'), 'class' => 'form-control', 'required', 'min' => 1, 'step' => 1]) }}
                                        </div>

                                        {{ Form::date('ends_at', $data->ends_at ?? \Carbon\Carbon::now(), ['id' => 'ends_at']) }}
                                    </div>

                                </div>

                            </div>
                            <hr>
                            {{ Form::submit(__('message.save'), ['class' => 'btn btn-md btn-primary float-right']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

    @section('bottom_script')
        <script>
            $(document).ready(function() {

                let startDateType = $('input[name="start_date_type"]:checked').val();
                let endDateType = $('input[name="end_date_type"]:checked').val();

                setTimeout(() => {
                    
                    setStartDateType(startDateType);
                    setEndDateType(endDateType);

                }, 300);


                $('#days-to-expiration').show();
                $('#ends_at').hide();

                $('input[type=radio][name=start_date_type]').change(function() {
                    // console.log(this.value);
                    // if (this.value == 'fixed') {
                    //     $('#starts_at').show();
                    // } else {
                    //     $('#starts_at').hide();
                    // }
                    setStartDateType(this.value);
                });

                $('input[type=radio][name=end_date_type]').change(function() {
                    // console.log(this.value);
                    // if (this.value == 'fixed') {
                    //     $('#ends_at').show();
                    //     $('#days-to-expiration').hide();
                    //     $('[name=days_to_expiration]').removeAttr('required');
                    // } else {
                    //     $('#ends_at').hide();
                    //     $('#days-to-expiration').show();
                    //     $('[name=days_to_expiration]').attr('required');
                    // }
                    setEndDateType(this.value);
                });
            });

            function setStartDateType(type) {
                if (type == 'fixed') {
                    $('#starts_at').show();
                } else {
                    $('#starts_at').hide();
                }
            }

            function setEndDateType(type) {
                if (type == 'fixed') {
                    $('#ends_at').show();
                    $('#days-to-expiration').hide();
                    $('[name=days_to_expiration]').removeAttr('required');
                } else {
                    $('#ends_at').hide();
                    $('#days-to-expiration').show();
                    $('[name=days_to_expiration]').attr('required');
                }
            }
        </script>
    @endsection

</x-master-layout>
