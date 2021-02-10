<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workstation extends Model
{

    protected $with = ['location'];
    protected $hidden = ['favoriteByUsers'];

    public function location()
    {
        return $this->belongsTo('App\Models\Location');
    }
}
