@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Solicitudes de atención en {{ $station->name }}</div>

                <div class="panel-body">
                    <div>
                        Ubicación:
                        <img src="{{ $station->mapSrc }}">
                    </div>

                    <table class="table">
                        <tr>
                            <th>#</th>
                            <th>Detalle</th>
                            <th>Mapa</th>
                        </tr>
                        @foreach($criminal_acts as $ca)
                           <tr>
                                <td>
                                    {{ $ca->id }}
                                </td>
                                <td>
                                    {{ $ca->details }}
                                </td>
                                <td>
                                    <img src="{{ $ca->mapSrc }}">
                                </td>
                           </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
