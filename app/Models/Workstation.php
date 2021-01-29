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
    public function favoriteByUsers()
    {
        return $this->belongsToMany('App\Models\User', 'favorites', 'workstation_id', 'user_id');
    }
    public function toArray()
    {
        $parent =  parent::toArray();

        if ( Auth::check() ){
            $parent['isFavorite'] = $this->isFavorite();
        }

        return $parent;
    }
    public function isFavorite(){
        foreach ($this->favoriteByUsers as $user) {
            if($user->user_id == Auth::id()) return true;
        }
        return false;
    }



}
