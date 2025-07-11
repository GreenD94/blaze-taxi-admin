{{ Form::model($setting_value, ['method' => 'POST','route' => ['settingUpdate'],'enctype'=>'multipart/form-data','data-toggle'=>'validator']) }}
    {{ Form::hidden('id', null, ['class' => 'form-control'] ) }}
    {{ Form::hidden('page', $page, ['class' => 'form-control'] ) }}
    <div class="row">

        <div class="col-md-12 col-sm-12 card shadow mb-10">
            <div class="card-header">
                <h4>Modalidades de Viaje</h4>
            </div>
            <div class="card-body">
                <div class="row">

                    <div class="form-group col-sm-6">

                        <div class="custom-control custom-checkbox custom-control-inline">
                            <input type="checkbox" class="custom-control-input" id="express" {{ ($setting_value->where('key','RIDE_MODALITY_EXPRESS')->first()->value ?? 0) == 1 ? 'checked' : '' }} name="express" value="1">
                            <label class="custom-control-label" for="express">Express</label>
                        </div>

                        <div class="custom-control custom-checkbox custom-control-inline">
                            <input type="checkbox" class="custom-control-input" id="auction" {{ ($setting_value->where('key','RIDE_MODALITY_AUCTION')->first()->value ?? 0) == 1 ? 'checked' : '' }} name="auction" value="1">
                            <label class="custom-control-label" for="auction">Subasta</label>
                        </div>

                    </div>

                    <div class="col-md-12">
                        {!! Form::submit( __('message.save'), [ 'class' => 'btn btn-md btn-primary' ]) !!}
                    </div>

                </div>
            </div>
        </div>

        @foreach($setting as $key => $value)
            <div class="col-md-12 col-sm-12 card shadow mb-10">
                <div class="card-header">
                    <h4>{{ $key }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($value as $sub_keys => $sub_value)
                            @php
                                $data=null;
                                foreach($setting_value as $v){

                                    if($v->key==($key.'_'.$sub_keys)){
                                        $data = $v;
                                    }
                                }
                                $class = 'col-md-6';
                                $type = 'text';
                                switch ($key){
                                    case 'FIREBASE':
                                        $class = 'col-md-12';
                                        break;
                                    case 'COLOR' : 
                                        $type = 'color';
                                        break;
                                    case 'DISTANCE' :
                                        $type = 'number';
                                    default : break;
                                }
                            @endphp
                            <div class=" {{ $class }} col-sm-12">
                                <div class="form-group">
                                    <label for="{{ $key.'_'.$sub_keys }}">{{ str_replace('_',' ',$sub_keys) }} </label>
                                    {{ Form::hidden('type[]', $key , ['class' => 'form-control'] ) }}
                                    <input type="hidden" name="key[]" value="{{ $key.'_'.$sub_keys }}">
                                    @if($key == 'CURRENCY' && $sub_keys == 'CODE')
                                        @php
                                            $currency_code = $data->value ?? 'USD';
                                            $currency = currencyArray($currency_code);
                                        @endphp
                                        <select class="form-control select2js" name="value[]" id="{{ $key.'_'.$sub_keys }}">
                                            @foreach(currencyArray() as $array)
                                                <option value="{{ $array['code'] }}" {{ $array['code'] == $currency_code  ? 'selected' : '' }}> ( {{$array['symbol']  }}  ) {{ $array['name'] }}</option>
                                            @endforeach
                                        </select>
                                    @elseif($key == 'CURRENCY' && $sub_keys == 'POSITION')
                                        {{ Form::select('value[]',['left' => __('message.left') , 'right' => __('message.right') ], isset($data) ? $data->value : 'left',[ 'class' =>'form-control select2js']) }}
                                    @else
                                        <input type="{{ $type }}" name="value[]" value="{{ isset($data) ? $data->value : null }}" id="{{ $key.'_'.$sub_keys }}" {{ $type == 'number' ? "min=0 step='any'" : '' }} class="form-control form-control-lg" placeholder="{{ str_replace('_',' ',$sub_keys) }}">
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        <div class="col-md-12">
                            {!! Form::submit( __('message.save'), [ 'class' => 'btn btn-md btn-primary' ]) !!}
                        </div>
                    </div>
                </div>
            </div>
        @endForeach
    </div>
{{ Form::submit(__('message.save'), ['class'=>"btn btn-md btn-primary float-md-right"]) }}
{{ Form::close() }}

<script>
    $(document).ready(function() {
        $('.select2js').select2();
    });
</script>
