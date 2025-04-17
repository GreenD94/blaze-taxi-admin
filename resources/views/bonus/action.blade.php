
<?php
    $auth_user= authSession();
?>
{{ Form::open(['route' => ['bonus.destroy', $id], 'method' => 'delete','data--submit'=>'bonus'.$id]) }}

<div class="d-flex justify-content-end align-items-center">
    @if($auth_user->can('bonus edit'))
    <a class="mr-2" href="{{ route('bonus.edit', $id) }}" title="{{ __('message.update_form_title',['form' => __('message.bonus') ]) }}"><i class="fas fa-edit text-primary"></i></a>
    @endif

    @if($auth_user->can('bonus delete'))
    <a class="mr-2 text-danger" href="javascript:void(0)" data--submit="bonus{{$id}}" 
        data--confirmation='true' data-title="{{ __('message.delete_form_title',['form'=> __('message.bonus') ]) }}"
        title="{{ __('message.delete_form_title',['form'=>  __('message.bonus') ]) }}"
        data-message='{{ __("message.delete_msg") }}'>
        <i class="fas fa-trash-alt"></i>
    </a>
    @endif
</div>

{{ Form::close() }}