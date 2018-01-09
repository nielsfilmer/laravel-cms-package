@if ($showLabel && $showField)
    @if ($options['wrapper'] !== false)
        <div {!! $options['wrapperAttrs'] !!}>
    @endif
@endif

@if ($showLabel && $options['label'] !== false)
    {!! Form::label($name, $options['label'], $options['label_attr']) !!}
@endif

@if ($showField)
    @if(!empty($options['value']))
        <div>
            <img src="{{ $options['value'] }}" class="form-image-file" style="max-width: 100%" />
        </div>
    @endif

    @if($options['editable'])
        {!! Form::input('file', $name, $options['value'], $options['attr']) !!}
    @endif

    @include('laravel-form-builder::help_block')
@endif

@include('laravel-form-builder::errors')

@if ($showLabel && $showField)
    @if ($options['wrapper'] !== false)
        </div>
    @endif
@endif
