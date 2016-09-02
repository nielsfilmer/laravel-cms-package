@if($btn_stats)<a data-text="stats" title="Stats" href="/{{ $slug }}/{{ $key }}/stats"><i class="glyphicon glyphicon-stats"></i></a> @endif
@if($btn_show)<a data-text="view" title="View" href="/{{ $slug }}/{{ $key }}"><i class="glyphicon glyphicon-search"></i></a> @endif
@if($btn_edit)<a data-text="edit" title="Edit" href="/{{ $slug }}/{{ $key }}/edit"><i class="glyphicon glyphicon-edit"></i></a> @endif
@if($btn_clone)<a data-text="clone" title="Clone" href="/{{ $slug }}/{{ $key }}/clone"><i class="glyphicon glyphicon-copy"></i></a> @endif
@if($btn_destroy)<a class="rest" title="Delete" data-method="DELETE" data-text="delete" href="/{{ $slug }}/{{ $key }}"><i class="glyphicon glyphicon-trash"></i></a>@endif
