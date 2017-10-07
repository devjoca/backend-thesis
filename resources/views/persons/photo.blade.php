@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Person Form</div>

                <div class="panel-body">
                    <form method="post" action="/person/{{ $person_id }}/photo/store" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="file" name="photo" value=""><br>
                        <input type="submit" name="Enviar">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
