<div class="{{$viewClass['form-group']}} {!! !$errors->has($errorKey) ? '' : 'has-error' !!}">

    <label class="{{$viewClass['label']}} control-label">{{$label}}</label>

    <div class="{{$viewClass['field']}}">

        @include('admin::form.error')

        <textarea name="{{ $name }}" placeholder="{{ $placeholder }}" {!! $attributes !!} >{!! $value !!}</textarea>

        @include('admin::form.help-block')

    </div>
</div>

<script require="@ckeditor" init="{!! $selector !!}">
    $this.ckeditor(()=>{},{
        filebrowserBrowseUrl: `{{ $filebrowserBrowseUrl }}`+'?type=Files',
        filebrowserImageBrowseUrl: `{{$filebrowserBrowseUrl}}`+'?type=Images',
        filebrowserUploadUrl: `{{$filebrowserUploadUrl}}`+'?command=QuickUpload&type=Files',
        filebrowserImageUploadUrl: `{{$filebrowserUploadUrl}}`+'?command=QuickUpload&type=Images',
        fullPage: $('{{ $selector }}').attr('data-full')
    });
</script>
