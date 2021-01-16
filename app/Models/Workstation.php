<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Favorite;

class Workstation extends Model
{

    protected $with = ['location'];

    public function location()
    {
        return $this->belongsTo('App\Models\Location');
    }

    public function favorited()
    {
        return (bool) Favorite::  where('user_id', Auth::id())
            ->where('workstation_id', $this->id)
            ->first();
    }

}
