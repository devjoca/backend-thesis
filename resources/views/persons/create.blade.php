@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Person Form</div>

                <div class="panel-body">
                    <form method="post" action="/person/store">
                        {{ csrf_field() }}
                        DNI: <input type="text" name="dni" value=""><br>
                        Name: <input type="text" name="name" value=""><br>
                        <input type="submit" name="Enviar">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
