@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">

                <div class="panel-heading">Person List</div>
                @if(session('message'))
                    <div class="panel-body">
                        {{ session('message') }}
                    </div>
                @endif
                <div class="panel-body">
                    <a href="/person/create">Create a Person</a>
                    <a href="/person/search">Search Person</a>
                    <a href="/person/train">Train data</a>
                    Training-status: {{ $status }}
                </div>

                <div class="panel-body">
                    <table class="table">
                        <tr>
                            <td>name</td>
                            <td>lastname</td>
                            <td>dni</td>
                            <td>delete</td>
                            <td>photos</td>
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
                                        <input type="submit" value="delete">
                                    </form>
                                </td>
                                <td>
                                    <a href="/person/{{ $person['microsoft_person_id'] }}/photo">Add photos</a>
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
