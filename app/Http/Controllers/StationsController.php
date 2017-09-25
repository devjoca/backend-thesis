<?php

namespace App\Http\Controllers;

use App\Station;
use App\CriminalAct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StationsController extends Controller
{
    public function index()
    {
        return Station::with('jurisdictions')->get();
    }

    public function find($station_id)
    {
        return Station::with('jurisdictions')->find($station_id);
    }

    public function list()
    {
        return view('stations.index', ['stations' => Station::all()]);
    }

    public function listOfCriminalActs($station_id)
    {
        $station = Station::find($station_id);
        $criminal_acts = CriminalAct::whereStationId($station_id)->with('station')->get();

        $criminal_acts->map(function($ca) {
            $ca['mapSrc'] = $ca->getMap();
            return $ca;
        });
        return view('stations.criminal_acts', compact('criminal_acts', 'station'));
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

    public function hotspots($station_id)
    {
        return view('stations.hotspots-map', ['station'=> Station::find($station_id)]);
    }
}
