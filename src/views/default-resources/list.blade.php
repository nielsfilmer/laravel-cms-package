<div class="panel panel-default">
    @if(is_array($heading))
        <ol class="breadcrumb panel-heading">
            @foreach($heading as $display=>$url)
                @if(!empty($url))
                    <li><a href="{{ $url }}">{{ $display }}</a></li>
                @else
                    <li>{{ $display }}</li>
                @endif
            @endforeach
            @if(isset($show_add) && $show_add)<a class="btn btn-primary btn-xs pull-right" href="{{ $list->getCreateUrl() }}">New {{ $object_name }}</a>@endif
        </ol>
    @else
        <div class="panel-heading">
            {{ $heading }}
            @if(isset($show_add) && $show_add)<a class="btn btn-primary btn-xs pull-right" href="{{ $list->getCreateUrl() }}">New {{ $object_name }}</a>@endif
        </div>
    @endif

    <div class="panel-body">
        @include('flash::message')
        {!! $list->render() !!}
    </div>
</div>
