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

    <div id="{{ $options['id'] }}">
        <input class="form-control" type="number" style="display: inline-block; width: 200px;" name="fromto-from" value="{{ $options['value-from'] }}" /> t/m <input type="number" class="form-control" style="display: inline-block; width: 200px;" name="fromto-to" value="{{ $options['value-to'] }}" />
        {!! Form::input('hidden', $name, $options['value'], $options['attr']) !!}
    </div>
    @include('laravel-form-builder::help_block')


    <script>
        $(function() {
            function onChange() {
                var from = $from.val();
                var to = $to.val();
                $input.val(from+'|'+to);
            }

            var id = '{{$options['id']}}';
            var name = '{{$name}}';
            var $el = $('#'+id);

            var $from = $el.find('input[name=fromto-from]');
            var $to = $el.find('input[name=fromto-to]');
            var $input = $el.find('input[name="'+name+'"]');

            $from.change(onChange);
            $to.change(onChange);
            onChange();
        });
    </script>
@endif

@include('laravel-form-builder::errors')

@if ($showLabel && $showField)
    @if ($options['wrapper'] !== false)
        </div>
    @endif
@endif
