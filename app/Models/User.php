<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstName',
        'lastName',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function favorites()
    {
        return $this->belongsToMany('App\Models\Workstation', 'favorites', 'user_id', 'workstation_id');
    }

    public function buddiesOfThisUser(){
        return $this->belongsToMany(User::class , 'buddies' , 'buddy_id' , 'user_id' ) ;
    }
    public function UserIsBuddyOf(){
        return $this->belongsToMany(User::class , 'buddies' , 'user_id' , 'buddy_id' ) ;
    }
    public function toArray()
    {
        $parent =  parent::toArray();

        if ( Auth::check() ){
            $parent['isBuddy'] = $this->isBuddy();
        }

        return $parent;
    }
    public function isBuddy()
    {
        foreach ($this->buddiesOfThisUser as $user) {
            if ($user->user_id == Auth::id()) return true;
        }
        return false;
    }

    public function ical() {
        return $this->hasOne(iCalAssignments::class, 'user_id', 'user_id');

    }
}
