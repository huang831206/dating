<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\User;


class UserRepository
{

    public static function getUserMatches($user_id)
    {
        // TODO:determine who the rating was rated by
        $matches = DB::table('matches')
                    // ->select('hash', 'rating_a', 'rating_b', 'created_at', 'updated_at')
                    ->where('user_a_id', $user_id)
                    ->orWhere('user_b_id', $user_id)
                    ->get();

        foreach ($matches as $match) {
            if ($user_id == $match->user_a_id) {    // in this match, user is a
                $match->me_rated = $match->rating_a;
                $match->i_rate = $match->rating_b;
                $match->other_profile = User::find($match->user_b_id)->profile;
            } else {                                // user is b
                $match->me_rated = $match->rating_b;
                $match->i_rate = $match->rating_b;
                $match->other_profile = User::find($match->user_a_id)->profile;
            }
            unset($match->id);
            unset($match->user_a_id);
            unset($match->user_b_id);
            unset($match->rating_a);
            unset($match->rating_b);
            unset($match->other_profile->id);
            unset($match->other_profile->user_id);
            unset($match->other_profile->created_at);
            unset($match->other_profile->updated_at);
        }

        return $matches;
    }

    public static function getUserApprovedInvitations($user)
    {
        return DB::table('invitations')->where('approved', true)
                                ->where('from_user_id', $user->id)
                                ->orWhere('to_user_id', $user->id)
                                ->get();
    }

    public static function setCurrentMatchHash(User $user, $hash)
    {
        $user->current_match = $hash;
        $user->save();
    }
}
