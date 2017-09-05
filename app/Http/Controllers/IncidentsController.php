<?php

namespace App\Http\Controllers;

use App\Incident;
use Illuminate\Http\Request;

class IncidentsController extends Controller
{
    public function store() {
        return Incident::create(request()->only(
            'person_name',
            'person_document_number',
            'datetime',
            'lat',
            'long',
            'aditional_information'
        ));
    }
}
