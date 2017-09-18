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
}
