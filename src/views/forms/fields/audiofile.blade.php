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
        <audio controls class="form-audio-file">
            <source src="{{ $options['value'] }}" type="{{ $options['mime-type'] }}">
            Your browser does not support the audio element.
        </audio>
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
