<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Invitation;
use App\Match;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use \Exception;

use App\Events\InvitationRecieved;

use App\Repository\MatchRepository;
use App\Repository\UserRepository;

class InvitationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['success'] = false;

        try {
            $user = Auth::user();
            $data['data'] = UserRepository::getUserApprovedInvitations($user);
        } catch (Exception $e) {
            $data['errors']['type'] = 'error';
            $data['errors']['message'] = $e->getTrace();
            return response()->json($data);
        }

        $data['success'] = true;
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

            $papers = DB::table('papers')->select('id', 'name_ch')
                                         ->inRandomOrder()
                                         ->limit(5)->get()->all();
            $d = $request->data;
            $d['papers'] = $papers;

            $invitation = Invitation::create([
                'match_id' => $match->id,
                'from_user_id' => $user->id,
                'to_user_id' => $matcherId,
                'data' => json_encode($d),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);

            // make a new invitation event, then broadcast
            broadcast(new InvitationRecieved($invitation))->toOthers();

            $data['success'] = true;
            $data['invitation'] = $invitation;
            $data['invitation']['data'] = json_decode($data['invitation']['data']);

            return response()->json($data);
        } catch (Exception $e) {

            $data['errors']['type'] = 'error';
            $data['errors']['message'] = $e->getTrace();
            return response()->json($data);
        }
    }

    public function approve(Request $request)
    {
        if ( DB::table('invitations')->where('id', $request->invitation_id)->update(['approved' => true]) ){
            $data['success'] = true;
        } else {
            $data['success'] = false;
        }
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invitation  $invitation
     * @return \Illuminate\Http\Response
     */
    public function show(Invitation $invitation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invitation  $invitation
     * @return \Illuminate\Http\Response
     */
    public function edit(Invitation $invitation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invitation  $invitation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invitation $invitation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invitation  $invitation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invitation $invitation)
    {
        //
    }

    // calculate recommendation
    public function calculate(Request $request)
    {
        $map = [
            23, 22, 21,
            19, 13, 12,
            28, 20, 14,
            20, 20, 19,
            16, 14, 14,
            11, 27, 10,
            8, 5, 3, 2
        ];

        $scores = [];

        try {
            $user = Auth::user();
            $lat = $request->lat;
            $lng = $request->lng;
            $locationId = $user->profile->location_id;
            $city = DB::table('location')
                        ->select('city')
                        ->where('id', $locationId)
                        ->first()->city;

            // get weather data
            $client = new \GuzzleHttp\Client();
            $res = $client->request('GET', 'http://opendata.epa.gov.tw/ws/Data/ATM00698/?$format=json');

            if ($res->getStatusCode() == 200) {
                $newestSites = array_slice(json_decode($res->getBody()), 0, 30);

                $site = $newestSites[$map[$locationId-1]];
                $scores['weather'] = $this->getWeatherScore($site);
            }

            // get uv data
            $client2 = new \GuzzleHttp\Client();
            $res2 = $client2->request('GET', 'http://opendata2.epa.gov.tw/UV/UV.json');
            $uvMap = [25, 0, 2, 4, 11, 12, 23, 28, 14, 28, 3, 5, 6, 7, 8, 13, 17, 33, 20, 16, 18, 32];

            if ($res->getStatusCode() == 200) {
                $uvData = json_decode($res2->getBody());

                $site = $uvData[$uvMap[$locationId-1]];
                $scores['weather'] += $this->getUVScore($site);
            }

            // get traffic data
            $sites = DB::table('bikes')->whereBetween('lat', [$lat-0.005, $lat+0.005])
                              ->whereBetween('lng', [$lng-0.005, $lng+0.005])
                              ->get();

            $scores['traffic'] = 50 + count($sites)?:0 *10;



        } catch (Exception $e) {
            $data['success'] = false;
            return response()->json($data);
        }

        $data['success'] = true;
        $data['data'] = $scores;

        return response()->json($data);

    }

    private function getWeatherScore($site)
    {
        $score = 100;
        $score -= abs($site->Moisture ?: 0 - 50);
        $score -= 10*$site->WindPower;
        $score -= 10*$site->Rainfall1day;
        return $score;
    }

    private function getUVScore($site)
    {
        return 100 - 10*$site->UVI;
    }
}
