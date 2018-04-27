<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Match;
use App\User;


class MatchRepository
{

    // find who the given user is talking to, if the given user is not in this match, return null
    public static function matcher(Match $match, User $user) {
        if ($match->user_a_id == $user->id) {
            return $match->user_b_id;
        } else if ($match->user_b_id == $user->id) {
            return $match->user_a_id;
        } else {
            return null;
        }
    }

    public static function inMatch(User $user, $hash) {
        // see if the user bbelongs to the match having the hash
        // $ab = DB::table('matches')->select('user_a_id','user_b_id')->where('hash', $hash)->get()->all();
        // return !empty($ab) && ($ab[0]->user_a_id == $user->id || $ab[0]->user_b_id == $user->id);

        return ($user->current_match == $hash);
    }

    public static function makeNewMatch(User $user_a, User $user_b) {
        $match = Match::create([
            'user_a_id' => $user_a->id,
            'user_b_id' => $user_b->id,
        ]);
        // calculate hash by match id, which will never overlap
        $match->hash = self::hashMatch($match->id);
        $match->save();

        // update these two user's current_match
        UserRepository::setCurrentMatchHash($user_a, $match->hash);
        UserRepository::setCurrentMatchHash($user_b, $match->hash);

        return $match;
    }

    // set hash to null
    public static function endMatchByHash($hash)
    {
        DB::table('users')->where('current_match', $hash)->update(['current_match'=>null]);
    }

    public static function endMatch(Match $match)
    {
        $match->userA->current_match = null;
        $match->userA->save();
        $match->userB->current_match = null;
        $match->userB->save();
    }

    public static function hashMatch($match_id) {
        return md5($match_id);
    }

    public static function getMatcherProfile(Match $match, User $user) {
        $matcherId = self::matcher($match, $user);

        $profile = DB::table('profiles')->where('user_id', $matcherId)
                             ->join('location', 'profiles.location_id', '=', 'location.id')
                             ->join('research_area', 'profiles.research_area_id', '=', 'research_area.id')
                             ->select('hobby', 'introduction', 'gender', 'city', 'area')
                             ->get()->first();

        return $profile;
    }
}
