{{ Form::model($referrals_setting, ['method' => 'POST', 'route' => ['referralSettingsUpdate'], 'enctype' => 'multipart/form-data', 'data-toggle' => 'validator']) }}

{{ Form::hidden('id', null, ['placeholder' => 'id', 'class' => 'form-control']) }}
{{ Form::hidden('page', $page, ['placeholder' => 'id', 'class' => 'form-control']) }}
<div class="row">
    <div class="col-lg-6">

        <div class="form-group">

            {{ Form::label("Activar Referidos", __('message.activate_referral_program'), ['class' => 'form-control-label']) }}
            <div class="d-block">
                <div class="custom-control custom-radio custom-control-inline col-2">
                    {{ Form::radio('referral_enabled', '1', old('referral_enabled') || true, ['class' => 'custom-control-input', 'id' => 'activate_referral_program_yes']) }}
                    {{ Form::label('activate_referral_program_yes', __('message.yes'), ['class' => 'custom-control-label']) }}
                </div>
                <div class="custom-control custom-radio custom-control-inline col-2">
                    {{ Form::radio('referral_enabled', '0', old('referral_enabled'), ['class' => 'custom-control-input', 'id' => 'activate_referral_program_no']) }}
                    {{ Form::label('activate_referral_program_no', __('message.no'), ['class' => 'custom-control-label']) }}
                </div>
            </div>
        </div>


    </div>

    <div class="col-lg-6">
        <div class="form-group">
            {{ Form::label('referral_amount', __('message.referral_bonus'), ['class' => 'col-sm-6  form-control-label']) }}
            <div class="col-sm-12">
                {{ Form::text('referral_amount', null, ['class' => 'form-control', 'placeholder' => __('message.referral_amount')]) }}
            </div>
        </div>
    </div>

    <hr>

    <div class="col-lg-12">
        <div class="form-group">
            <div class="col-md-offset-3 col-sm-12 ">
                {{ Form::submit(__('message.save'), ['class' => 'btn btn-md btn-primary float-md-right']) }}
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}
<script>
    function getExtension(filename) {
        var parts = filename.split('.');
        return parts[parts.length - 1];
    }

    function isImage(filename) {
        var ext = getExtension(filename);
        switch (ext.toLowerCase()) {
            case 'jpg':
            case 'jpeg':
            case 'png':
            case 'gif':
            case 'ico':
                return true;
        }
        return false;
    }

    function readURL(input, className) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            var res = isImage(input.files[0].name);
            if (res == false) {
                var msg = 'Image should be png/PNG, jpg/JPG & jpeg/JPG.';
                Snackbar.show({
                    text: msg,
                    pos: 'bottom-right',
                    backgroundColor: '#d32f2f',
                    actionTextColor: '#fff'
                });
                $(input).val("");
                return false;
            }
            reader.onload = function(e) {
                $(document).find('img.' + className).attr('src', e.target.result);
                $(document).find("label." + className).text((input.files[0].name));
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    $(document).ready(function() {
        $('.select2js').select2();
        $(document).on('change', '#site_logo', function() {
            readURL(this, 'site_logo');
        });
        $(document).on('change', '#site_favicon', function() {
            readURL(this, 'site_favicon');
        });

        $('.default_language').on('change', function(e) {
            var id = $(this).val();
            $('.language_option option:disabled').prop('selected', true);
            $('.language_option option').prop('disabled', false);

            $('.language_option option').each(function(index, val) {
                var $this = $(this);
                if (id == $this.val()) {
                    $this.prop('disabled', true);
                    $this.prop('selected', false);
                }
            });
            $('.language_option').select2("destroy").select2();
        });
    })
</script>
