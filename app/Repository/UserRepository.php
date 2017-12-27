<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class UserRepository
{

    public static function getUserMatches($user_id)
    {
        return DB::table('mathes')->where('user_a_id', $user_id)->orWhere('user_b_id', $user_id)->get();
    }
}
