<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function matches()
    {
        // return $this->hasMany('App\User', 'user_a_id')
        //             ->concat($this->hasMany('App\User', 'user_b_id'));

        return DB::table('matches')->where('user_a_id', $this->id)->orWhere('user_b_id', $this->id)->get();

    }

    public function profile()
    {
        return $this->hasOne('App\Profile');
    }

}
