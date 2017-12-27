<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];


    public function messages()
    {
        return $this->hasMany('App\Message');
    }

    public function userA()
    {
        return $this->belongsTo('App\User', 'user_a_id');
    }

    public function userB()
    {
        return $this->belongsTo('App\User', 'user_b_id');
    }

    /**
    * Get the route key for the model.
    *
    * @return string
    */
    public function getRouteKeyName()
    {
        return 'hash';
    }

}
