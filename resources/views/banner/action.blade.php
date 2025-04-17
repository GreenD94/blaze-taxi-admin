
<?php
    $auth_user= authSession();
?>
{{ Form::open(['route' => ['banner.destroy', $id], 'method' => 'delete','data--submit'=>'banner'.$id]) }}

<div class="d-flex justify-content-end align-items-center">
    @if($auth_user->can('banner edit'))
    <a class="mr-2" href="{{ route('banner.edit', $id) }}" title="{{ __('message.update_form_title',['form' => __('message.banner') ]) }}"><i class="fas fa-edit text-primary"></i></a>
    @endif

    @if($auth_user->can('banner delete'))
    <a class="mr-2 text-danger" href="javascript:void(0)" data--submit="banner{{$id}}" 
        data--confirmation='true' data-title="{{ __('message.delete_form_title',['form'=> __('message.banner') ]) }}"
        title="{{ __('message.delete_form_title',['form'=>  __('message.banner') ]) }}"
        data-message='{{ __("message.delete_msg") }}'>
        <i class="fas fa-trash-alt"></i>
    </a>
    @endif
</div>

{{ Form::close() }}