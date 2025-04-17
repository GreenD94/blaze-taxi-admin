<!-- Modal -->

<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{ $rider->first_name }} {{ $rider->last_name }} 
                -
                Saldo Actual: ${{  number_format($rider->userWallet->total_amount ?? 0, 2, ',', '.') }}
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
       {{ Form::open(['route' => ['rider.wallet.save', $rider->id],'method' => 'put','data-toggle'=>"validator"]) }}
        <div class="modal-body">

           {{ Form::hidden('user_id',$rider->id) }}
           {{ Form::hidden('currency', 'usd') }}
           {{ Form::hidden('transaction_type', 'recharge') }}
           {{ Form::hidden('id',-1) }}
            <div class="row">

                <div class="col-md-12 form-group">
                   {{ Form::label('amount',__('message.amount').' <span class="text-danger">*</span>', ['class' => 'form-control-label'],false) }}
                   {{ Form::number('amount', null, [ 'placeholder' => __('message.amount') ,'class' => 'form-control' ,'required', 'step' => '0.01', 'min' => '0.01']) }}
                </div>
                
                <div class="col-md-12 form-group">
                   {{ Form::label('amount',__('message.type').' <span class="text-danger">*</span>', ['class' => 'form-control-label'],false) }}
                   {{ Form::select('type',[ 'credit' => __('message.credit'), 'debit' => __('message.debit') ], old('type'), [ 'class' =>'form-control select2js','required']) }}
                </div>

            </div>
            {{-- @if( $type == 'permission' )
                <div class="row">
                    <div class="col-md-12 form-group">
                    {{ Form::label('parent_id',__('message.parent_permission'), ['class' => 'form-control-label']) }}
                    <select name="parent_id" id="parent_id" class="select2js form-control" data-ajax--url="{{ route('ajax-list', ['type' => 'permission']) }}" data-ajax--cache = "true">
                       
                    </select>
                    </div>
                </div>
            @endif --}}
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-md btn-secondary" data-dismiss="modal">{{ __('message.close') }}</button>
            <button type="submit" class="btn btn-md btn-primary" id="btn_submit" data-form="ajax" >{{ __('message.save') }}</button>
        </div>
        {{ Form::close() }}
    </div>
</div>
<script>
    $('#parent_id').select2({
        width: '100%',
        placeholder: "{{ __('message.select_name',['select' => __('message.parent_permission')]) }}",
    });
</script>

