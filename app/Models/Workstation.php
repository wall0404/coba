<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workstation extends Model
{

    protected $with = ['location'];

    public function location()
    {
        return $this->belongsTo('App\Models\Location');
    }
}
