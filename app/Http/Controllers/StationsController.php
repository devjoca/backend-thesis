<?php

namespace App\Http\Controllers;

use App\Station;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StationsController extends Controller
{
    public function index()
    {
        return Station::all();
    }

    public function findNear()
    {
        $lat = request('lat');
        $long = request('long');

        return DB::table('stations AS s')
                 ->select(DB::Raw("* ,
                    (
                       6371 *
                       acos(cos(radians($lat)) *
                       cos(radians(s.lat)) *
                       cos(radians(s.long) -
                       radians($long)) +
                       sin(radians($lat)) *
                       sin(radians(s.lat)))
                    ) AS distance"))
                ->orderBy('distance', 'asc')
                ->take(5)
                ->get();

    }
}
