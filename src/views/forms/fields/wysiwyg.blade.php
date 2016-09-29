@section('css')

@endsection

@if ($showLabel && $showField)
    @if ($options['wrapper'] !== false)
        <div {!! $options['wrapperAttrs'] !!}>
    @endif
@endif

@if ($showLabel && $options['label'] !== false)
    {!! Form::label($name, $options['label'], $options['label_attr']) !!}
@endif

@if ($showField)
    <textarea id="trumbowyg-{{ $name }}" name="{{ $name }}">
        {!! $options['value'] !!}
    </textarea>

    @include('laravel-form-builder::help_block')
@endif

@include('laravel-form-builder::errors')

@if ($showLabel && $showField)
    @if ($options['wrapper'] !== false)
        </div>
    @endif
@endif


@section('script')

    @parent

    <script src="{{ asset('assets/js/vendor/trumbowyg.min.js') }}"></script>
    <script>
        $(function() {
            var name = '{{ $name }}';
            var removeformatPasted = {{ ($options['removeformatPasted']) ? 'true' : 'false' }};
            var btns = {!! $options['btns'] !!};
        $('#trumbowyg-'+name).trumbowyg({
            btns: btns,
            removeformatPasted: removeformatPasted
        });
        });
    </script>

@endsection