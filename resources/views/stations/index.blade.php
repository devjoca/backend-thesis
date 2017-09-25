@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Estaciones</div>

                <div class="panel-body">
                    <table class="table">
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th></th>
                            <th></th>
                        </tr>
                        @foreach($stations as $station)
                            <tr>
                                <td>{{ $station->id }}</td>
                                <td>{{ $station->name }}</td>
                                <td>{{ $station->description }}</td>
                                <td><a href="/comisarias/{{ $station->id }}/atenciones">Pedidos de atención </a></td>
                                <td><a href="/comisarias/{{ $station->id }}/puntos-conflicto">Puntos de conflicto </a></td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
