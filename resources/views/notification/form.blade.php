<x-master-layout :assets="$assets ?? []">
    <div>
        <?php $id = $id ?? null;?>
        @if(isset($id))
            {!! Form::model($data, ['route' => ['rider.update', $id], 'method' => 'patch' , 'enctype' => 'multipart/form-data']) !!}
        @else
            {!! Form::open(['route' => ['notification.send'], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
        @endif
        <div class="row">

            <div class="col-xl-12 col-lg-11">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">{{ $pageTitle }}</h4>
                        </div>
                        {{-- <div class="card-action">
                            <a href="{{route('rider.index')}}" class="btn btn-sm btn-primary" role="button">{{ __('message.back') }}</a>
                        </div> --}}
                    </div>
                    <div class="card-body">
                        <div class="new-user-info">
                            <div class="row">

                                <div class="form-group col-md-12">
                                    {{ Form::label('target',__('message.target').' <span class="text-danger">*</span>',['class'=>'form-control-label'],false) }}
                                    {{ Form::select('target',[ 'all' => __('message.all') ,'riders' => __('message.rider') , 'drivers' => __('message.driver') ], old('target') ,[ 'class' =>'form-control select2js','required']) }}
                                </div>

                                <div class="form-group col-md-12">
                                    {{ Form::label('title',__('message.title').' <span class="text-danger">*</span>',['class'=>'form-control-label'], false ) }}
                                    {{ Form::text('title',old('title'),['placeholder' => __('message.title'),'class' =>'form-control','required']) }}
                                </div>

                                <div class="form-group col-md-12">
                                    {{ Form::label('message',__('message.message'), ['class' => 'form-control-label']) }}
                                    {{ Form::textarea('message', null, ['class'=>"form-control textarea" , 'rows'=>3  , 'placeholder'=> __('message.message') ]) }}
                                </div>

                            </div>
                            <hr>
                            {{ Form::submit( __('message.send'), ['class'=>'btn btn-md btn-primary float-right']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</x-master-layout>
