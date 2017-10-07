@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">

                <div class="panel-heading">Lista de personas</div>
                @if(session('message'))
                    <div class="panel-body">
                        {{ session('message') }}
                    </div>
                @endif
                <div class="panel-body">
                    <a href="/person/create">Crear Persona</a>
                    <!-- <a href="/person/search">Buscar Persona</a> -->
                    <a class="btn btn-default" href="/person/train">Entrenar Datos</a>
                    Estado de entrenamiento: {{ ($status=='succeeded')?'exitoso':'fallido' }}
                </div>

                <div class="panel-body">
                    <table class="table">
                        <tr>
                            <td>Nombre</td>
                            <td>Apellido</td>
                            <td>DNI</td>
                            <td></td>
                            <td></td>
                        </tr>
                        @foreach($persons as $person)
                            <tr>
                                <td>
                                    {{ $person['name'] }}
                                </td>
                                <td>
                                    {{ $person['lastname'] }}
                                </td>
                                <td>
                                    {{ $person['dni'] }}
                                </td>
                                <td>
                                    <form method="post" action="/person/delete">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="person_id" value="{{ $person['microsoft_person_id'] }}">
                                        <input type="submit" value="Eliminar">
                                    </form>
                                </td>
                                <td>
                                    <a href="/person/{{ $person['microsoft_person_id'] }}/photo">Agregar fotos</a>
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
