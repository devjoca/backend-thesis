@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Solicitudes de desarrolladores</div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if($applicants->isNotEmpty())
                    <table class="table">
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th></th>
                        </tr>
                        @foreach($applicants as $a)
                            <tr>
                                <td>{{ $a->id }}</td>
                                <td>{{ $a->name }}</td>
                                <td>{{ $a->email }}</td>
                                <td><a href="/desarrolladores/{{ $a->id }}/aprobar">Aprobar</a></td>
                            </tr>
                        @endforeach
                    </table>
                    @else
                        <div>
                            <span>No hay solicitudes por el momento</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
