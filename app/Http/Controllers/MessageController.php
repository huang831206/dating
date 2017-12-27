<?php

namespace App\Http\Controllers;

use App\Match;
use App\Message;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use \Exception;

use App\Events\MessageReceived;

use App\Repository\MatchRepository;


class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $data['success'] = false;
        try {
            $user = Auth::user();

            if(!json_decode($request->getContent())){
                $data['errors']['type'] = 'validation';
                $data['errors']['message']= 'request data format invalid';
                return response()->json($data);
            }
            // channel hash, used to find match
            $hash = $request->hash;
            $message = trim($request->message);
            if(!$message){
                $data['errors']['type'] = 'validation';
                $data['errors']['message']= 'speak something!';
                return response()->json($data);
            }
            // find the match by hash
            $match = Match::where('hash', $hash)->first();
            if(!$match){    // match channel hash doesn't exist
                $data['errors']['type'] = 'authentication';
                $data['errors']['message']= 'you are not authenticated to do this';
                return response()->json($data);
            }

            // find who this user is talking to
            $matcherId = MatchRepository::matcher($match, $user);
            if(!$matcherId){    // user not in this match
                $data['errors']['type'] = 'authentication';
                $data['errors']['message']= 'you are not in a conversation yet';
                return response()->json($data);
            }

            $message = Message::create([
                'match_id' => $match->id,
                'from_user_id' => $user->id,
                'to_user_id' => $matcherId,
                'type' => 'text',
                'message' => $message,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);

            // make a new message event, then broadcast
            broadcast(new MessageReceived($message))->toOthers();

            $data['success'] = true;
            return response()->json($data);
        } catch (Exception $e) {

            $data['errors']['type'] = 'error';
            $data['errors']['message'] = $e->getTrace();
            return response()->json($data);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //abort(403, 'Unauthorized action.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }
}
