<x-master-layout :assets="$assets ?? []">
    <div>
        <?php $id = $id ?? null; ?>
        @if (isset($id))
            {!! Form::model($data, [
                'route' => ['banner.update', $id],
                'method' => 'patch',
                'enctype' => 'multipart/form-data',
            ]) !!}
        @else
            {!! Form::open(['route' => ['banner.store'], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
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
                            <a href="{{ route('banner.index') }}" class="btn btn-sm btn-primary"
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

                                <div class="form-group col-md-6" style="margin-top: 3.5%">
                                    {{-- {{ Form::label('image', __('message.name') . ' <span class="text-danger">*</span>', ['class' => 'form-control-label'], false) }} --}}

                                    {{ Form::file('image', ['class'=>"custom-file-input custom-file-input-sm detail form-control" , 'id'=>"image" , 'lang'=>"en" , 'accept'=>"image/*"]) }}
                                    <label class="custom-file-label" for="image">{{ __('message.image') }}</label>

                                    @isset($data) 
                                        <br>
                                        <img src="{{ getSingleMedia($data,'banner') }}" width="100"  id="app_image_preview" alt="app_image" class="image app_image app_image_preview">
                                    @endisset

                                </div>

                                <div class="form-group col-md-6">

                                    <label class="form-label">{{ __('message.user_type') }}</label>
                                    <div class="grid" style="--bs-gap: 1rem">

                                        <div class="form-check">
                                            {{ Form::radio('user_type', 'riders', old('user_type') || true, ['class' => 'form-check-input', 'id' => 'riders']) }}
                                            {{ Form::label('riders', __('message.rider'), ['class' => 'form-check-label']) }}
                                        </div>

                                        <div class="form-check">
                                            {{ Form::radio('user_type', 'drivers', old('user_type') || false, ['class' => 'form-check-input', 'id' => 'drivers']) }}
                                            {{ Form::label('drivers', __('message.driver'), ['class' => 'form-check-label']) }}
                                        </div>

                                    </div>

                                </div>
                                
                                <div class="form-group col-md-6">

                                    <label class="form-label">{{ __('message.banner_type') }}</label>

                                    <div class="grid" style="--bs-gap: 1rem">

                                        <div class="form-check">
                                            {{ Form::radio('type', 'popup', old('type') || true, ['class' => 'form-check-input', 'id' => 'popup', 'selected']) }}
                                            {{ Form::label('popup', __('message.banner_popup'), ['class' => 'form-check-label']) }}
                                        </div>

                                        <div class="form-check">
                                            {{ Form::radio('type', 'bottom', old('type') || false, ['class' => 'form-check-input', 'id' => 'bottom']) }}
                                            {{ Form::label('bottom', __('message.banner_bottom'), ['class' => 'form-check-label']) }}
                                        </div>

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

                let startDateType = $('input[name="user_type"]:checked').val();
                let endDateType = $('input[name="end_date_type"]:checked').val();

                setTimeout(() => {
                    
                    setStartDateType(startDateType);
                    setEndDateType(endDateType);

                }, 300);


                $('#days-to-expiration').show();
                $('#ends_at').hide();

                $('input[type=radio][name=user_type]').change(function() {
                    // console.log(this.value);
                    // if (this.value == 'riders') {
                    //     $('#starts_at').show();
                    // } else {
                    //     $('#starts_at').hide();
                    // }
                    setStartDateType(this.value);
                });

                $('input[type=radio][name=end_date_type]').change(function() {
                    // console.log(this.value);
                    // if (this.value == 'riders') {
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
                if (type == 'riders') {
                    $('#starts_at').show();
                } else {
                    $('#starts_at').hide();
                }
            }

            function setEndDateType(type) {
                if (type == 'riders') {
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
