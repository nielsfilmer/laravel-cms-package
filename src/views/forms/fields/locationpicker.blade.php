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

    <div class="locationpicker-{{ $name }}">
        {!! Form::input('text', $name, $options['value'], $options['attr']) !!}
        <div class="locationpicker-{{ $name }}-map" style="width: 100%; height: 400px; margin: 10px 0 20px;"></div>
    </div>

    @include('laravel-form-builder::help_block')
@endif

@include('laravel-form-builder::errors')

@if ($showLabel && $showField)
    @if ($options['wrapper'] !== false)
        </div>
    @endif
@endif


@section('script')

    <script type="text/javascript" src='http://maps.google.com/maps/api/js?sensor=false&libraries=places&key=AIzaSyBmuQP4SsRh3BYgpWqhzGM6DGH6nEtDU1o'></script>
    <script src="{{ url('/assets/js/vendor/locationpicker.jquery.min.js') }}"></script>
    <script>
        $(function() {
            var name = '{{$name}}';
            var lat_name = '{{$options['lat-name']}}';
            var lng_name = '{{$options['lng-name']}}';
            var lat = '{{$options['lat-value']}}';
            var lng = '{{$options['lng-value']}}';

            $('.locationpicker-'+name+'-map').locationpicker({
                location: {latitude: lat, longitude: lng},
                radius: 0,
                inputBinding: {
                    locationNameInput: $('input[name='+name+']'),
                    latitudeInput: $('input[name='+lat_name+']'),
                    longitudeInput: $('input[name='+lng_name+']')
                },
                enableAutocomplete: true
            });
        });

    </script>

@endsection