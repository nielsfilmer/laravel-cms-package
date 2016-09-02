@extends('layouts.app')

@section('content')
    <div class="panel panel-default">
        <ol class="breadcrumb panel-heading">
            @foreach($breadcrumb as $display=>$url)
                @if(!empty($url))
                    <li><a href="{{ $url }}">{{ $display }}</a></li>
                @else
                    <li>{{ $display }}</li>
                @endif
            @endforeach
        </ol>

        <div class="panel-body">
            @include('flash::message')
            {!! form($form) !!}
        </div>
    </div>
@endsection
