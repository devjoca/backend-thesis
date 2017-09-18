<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    protected $guard = [];

    public function jurisdictions()
    {
        return $this->hasOne(Jurisdiction::class);
    }

    public function getMapSrcAttribute()
    {
        return "http://maps.googleapis.com/maps/api/staticmap?size=374x200&zoom=16&markers={$this->lat},{$this->long}&key=".env('GMAPS_KEY');
    }
}
