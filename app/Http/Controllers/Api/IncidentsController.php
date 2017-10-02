<?php

namespace App\Http\Controllers\Api;

use App\Incident;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IncidentsController extends Controller
{
    public function index()
    {
        return Incident::paginate();
    }
}
