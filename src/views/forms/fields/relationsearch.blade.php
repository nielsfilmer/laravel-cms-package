@section('css')

    <style>
        .relationship-search > li:hover {
            cursor: pointer;
            background-color: #fafafa;
        }
    </style>

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

    <div class="relationsearch-{{ $name }}">
        {!! Form::input('text', $name . "-search", $options['value-display'], $options['attr']) !!}
        {!! Form::input('hidden', $name, $options['value'], $options['attr']) !!}
    </div>
    <script>
        $(function() {
            // Script for relation search
            var name = '{{$name}}';
            var $search = $('input[name='+name+'-search]');
            var $value = $('input[name='+name+']');
            var $list = $('<ul class="list-group relationship-search relationship-search-'+name+'"></ul>');
            var api = '{{ $options['api'] }}';

            var search = null;
            var timer;
            var timeout = 500;

            $search.keyup(function() {
                clearTimeout(timer);

                if($search.val() != "" && (search == null || $search.val() != search)) {
                    timer = setTimeout(function() {
                        search = $search.val();
                        $value.val('');

                        $.get(api + "?s=" + search, function (response) {
                            $list.remove();
                            $list.find('.list-group-item').remove();
                            displayRelations(response);
                        });
                    }, timeout);
                } else if($search.val() == "") {
                    $list.remove();
                    $list.find('.list-group-item').remove();
                    $value.val('');
                }
            });


            $search.blur(function() {
                setTimeout(function() {
                    $list.remove();
                    $list.find('.list-group-item').remove();
                }, 500);
            });


            function displayRelations(relations) {

                $.each(relations, function(i,v) {
                    $li = $('<li class="list-group-item"><span class="glyphicon glyphicon-user" aria-hidden="true" data-id="'+ v.id+'"></span> '+ v.name+'</li>');
                    $li.click(function(e) {
                        console.log("Selecting " + v.name);
                        $list.remove();
                        $list.find('.list-group-item').remove();
                        $value.val(v.id);
                        $search.val(v.name);
                        search = v.name;
                    });
                    $list.append($li);
                });

                $li = $('<li class="list-group-item new-item"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> '+ $search.val()+'</li>');
                $li.click(function() {
                    $list.remove();
                    $list.find('.list-group-item').remove();
                });
                $list.append($li);

                $list.width($search.outerWidth());
                $search.after($list);
            }
        });
    </script>

    @include('laravel-form-builder::help_block')
@endif

@include('laravel-form-builder::errors')

@if ($showLabel && $showField)
    @if ($options['wrapper'] !== false)
        </div>
    @endif
@endif
