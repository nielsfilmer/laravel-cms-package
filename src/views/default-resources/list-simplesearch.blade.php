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
            {{ $heading }} ({{ $total }})
            @if(isset($show_add) && $show_add)<a class="btn btn-primary btn-xs pull-right" href="{{ $list->getCreateUrl() }}">New {{ $object_name }}</a>@endif
            <form method="GET" class="form-heading-quicksearch col-xs-6 pull-right" style="position: relative; top: -7px;">
                <div class="input-group input-group-sm">
                    <input type="text" name="filter" class="form-control" placeholder="Zoeken" value="{{ $filter }}">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit">Go!</button>
                    </span>
                </div>
            </form>
        </div>
    @endif

    <div class="panel-body">
        @include('flash::message')
        {!! $list->render() !!}
    </div>
</div>
