@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $station->name }}</div>

                <div class="panel-body">
                    <station-map id="{{ $station->id }}" center_lat="{{ $station->lat }}" center_lng="{{ $station->long }}"></station-map>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
