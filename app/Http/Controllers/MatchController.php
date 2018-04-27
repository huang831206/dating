<?php

namespace App\Http\Controllers;

use App\Match;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Exception;

use App\Events\MatchEnded;

use App\Repository\MatchRepository;
use App\Repository\UserRepository;

class MatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $data['success'] = true;
        $matches = UserRepository::getUserMatches($user->id);

        // remove current match
        if($user->current_match){
            $matches->pop();
        }

        $data['data'] = $matches;

        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $user_a = User::find($request->user_a_id);
        $user_b = User::find($request->user_b_id);

        $match = MatchRepository::makeNewMatch($user_a, $user_b);

        $data['success'] = true;
        $data['hash'] = $match->hash;
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Match  $match
     * @return \Illuminate\Http\Response
     */
    // show the chat page
    public function show(Match $match)
    {
        // TODO:maybe this should serve for list match messages
        $user = Auth::user();
        $data = [];
        if ($user->current_match != $match->hash) {   // user is currerntly in the required match
            // return redirect()->route('home')->with('error', 'You are not authenticated to do this.');
            abort(404);
            // abort(403, 'Unauthorized action.');
        }

        $data['hash'] = $match->hash;
        $data['created_at'] = $match->created_at;
        $data['messages'] = $match->messages;

        $data['other_profile'] = MatchRepository::getMatcherProfile($match, $user);

        return view('chat')->with(['data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Match  $match
     * @return \Illuminate\Http\Response
     */
    public function edit(Match $match)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Match  $match
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Match $match)
    {
        $data['success'] = false;
        try {
            $user = Auth::user();
            if ($user->id == $match->user_a_id) {
                $match->rating_b = $request->rating;
            } else {
                $match->rating_a = $request->rating;
            }
            $match->save();
            $data['success'] = true;
        } catch (Exception $e) {
            $data['errors']['type'] = 'error';
            $data['errors']['message'] = $e->getTrace();
            return response()->json($data);
        }

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Match  $match
     * @return \Illuminate\Http\Response
     */
    public function destroy(Match $match)
    {
        MatchRepository::endMatch($match);

        broadcast(new MatchEnded($match->hash))->toOthers();
    }
}
