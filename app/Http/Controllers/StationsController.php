<?php

namespace App\Http\Controllers;

use App\Station;
use Illuminate\Http\Request;

class StationsController extends Controller
{
    public function index()
    {
        return Station::all();
    }
}
