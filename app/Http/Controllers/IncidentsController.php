<?php

namespace App\Http\Controllers;

use App\Incident;
use Illuminate\Http\Request;

class IncidentsController extends Controller
{
    public function index()
    {
        return Incident::all();
    }

    public function store() {
        return Incident::create(request()->only(
            'person_id',
            'email',
            'datetime',
            'lat',
            'long',
            'aditional_information',
            'denouncePersonDetails'
        ));
    }
}
