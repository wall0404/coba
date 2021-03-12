<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class Booking extends ParentModel
{
    use HasFactory;

    public function workstation()
    {
        return $this->belongsTo('App\Models\Workstation');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function checkGetRight()
    {
        return "all";
    }

    public function checkUpdateRight()
    {
        return $this->user_id == Auth::id();
    }

}
