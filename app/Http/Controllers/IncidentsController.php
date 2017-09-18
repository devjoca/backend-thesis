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

    public function search()
    {
        $start_hour = request('start_hour');
        $end_hour = request('end_hour');
        return Incident::where('datetime', '>=', request('start_date'))
                       ->where('datetime', '<=', request('end_date'))
                       ->whereRaw("HOUR(datetime)  BETWEEN {$start_hour['HH']} AND {$end_hour['HH']}")
                       ->whereRaw("MINUTE(datetime)  BETWEEN {$start_hour['mm']} AND {$end_hour['mm']}")->get();
    }
}
