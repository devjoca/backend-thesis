<?php

namespace App\Http\Controllers;

use App\CriminalAct;
use Illuminate\Http\Request;

class CriminalActsController extends Controller
{
    public function store()
    {
        return CriminalAct::create([
            'lat' => request('lat'),
            'long' => request('long'),
            'details' => request('details'),
            'station_id' => request('station_id'),
        ]);
    }
}
