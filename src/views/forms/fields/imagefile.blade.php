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
            <img src="{{ $options['value'] }}" class="form-image-file" />
        </div>
    @endif

    {!! Form::input('file', $name, $options['value'], $options['attr']) !!}

    @include('laravel-form-builder::help_block')
@endif

@include('laravel-form-builder::errors')

@if ($showLabel && $showField)
    @if ($options['wrapper'] !== false)
        </div>
    @endif
@endif
