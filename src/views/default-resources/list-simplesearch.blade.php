<div class="panel panel-default">
    <ol class="breadcrumb panel-heading">
        @if(is_array($heading))
            @foreach($heading as $display=>$url)
                @if(!empty($url))
                    <li><a href="{{ $url }}">{{ $display }}</a></li>
                @else
                    <li>{{ $display }}</li>
                @endif
            @endforeach
        @else
            <li>{{ $heading }} ({{ $total }})</li>
        @endif
        @if(isset($show_add) && $show_add)<a class="btn btn-primary btn-xs pull-right" href="{{ $list->getCreateUrl() }}">New {{ $object_name }}</a>@endif
        <form method="GET" class="form-heading-quicksearch col-xs-6 pull-right" style="position: relative; top: -7px;">
            <div class="input-group input-group-sm">
                <input type="text" name="filter" class="form-control" placeholder="Search" value="{{ $filter }}">
                <span class="input-group-btn">
                <button class="btn btn-default" type="submit">Go!</button>
            </span>
            </div>
        </form>
    </ol>

    <div class="panel-body">
        @include('flash::message')
        {!! $list->render() !!}
    </div>
</div>
