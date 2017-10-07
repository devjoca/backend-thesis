<?php

namespace App;

use Zttp\Zttp;
use Illuminate\Database\Eloquent\Model;

class CriminalAct extends Model
{
    protected $guarded = [];

    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    public function getMap()
    {
        $r =Zttp::get("https://maps.googleapis.com/maps/api/directions/json?origin={$this->lat},{$this->long}&destination={$this->station->lat},{$this->station->long}&languages=es&key=".env('GMAPS_KEY'));
        $data = $r->json();
        $encRoute = $data['routes'][0]['overview_polyline']['points'];

        return "https://maps.googleapis.com/maps/api/staticmap?size=764x400&zoom=15&markers={$this->lat},{$this->long}&path=enc%3A{$encRoute}&key=".env('GMAPS_KEY');
    }
}
