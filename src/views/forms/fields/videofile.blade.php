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
        <br>
        <video width="360" controls class="form-video-file">
            <source src="{{ $options['value'] }}" type="{{ $options['mime-type'] }}">
        </video>
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
