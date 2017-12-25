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
}
