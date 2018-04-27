<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Profile;


class UserController extends Controller
{

    public function profile(){
        $user = Auth::user();

        $data = [
            'success' => true,
            'is_profile_complete' => $user->is_profile_complete,
            'profile' => $user->profile
        ];

        return response()->json($data);
    }

    /**
     * Update logged in user info.
     */

    public function editProfile(Request $request){
        $user = Auth::user();

        // validate user inputs
        $validator = Validator::make($request->all(), [
            'hobby' => 'required',
            'area' => 'required|integer|between:1,21',
            'location' => 'required|integer|between:1,22',
            'introduction' => 'required'
        ]);

        $data['success'] = false;
        if($validator->fails()){
            $data['errors']['type'] = 'validation';
            $data['errors']['messages'] = $validator->errors()->all();
            return response()->json($data);
        }

        if ( !$user->is_profile_complete ) {
            // if the profile is not set yet, reate a new one
            $profile = Profile::create([
                'user_id' => $user->id,
                'hobby' => $request->hobby,
                'introduction' => $request->introduction,
                'location_id' => $request->location,
                'research_area_id' => $request->area,
                'gender' => $request->gender,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
            $user->is_profile_complete = true;
            $user->save();
        } else {
            $user->profile->gender = $request->gender;
            $user->profile->hobby = $request->hobby;
            $user->profile->research_area_id = $request->area;
            $user->profile->location_id = $request->location;
            $user->profile->introduction = $request->introduction;
            $user->profile->save();
        }

        $data['success'] = true;
        $data['profile'] = $user->profile;

        return response()->json($data);
    }

    public function pair(Request $request)
    {
        $user = Auth::user();
        if ($user->current_match && $user->is_profile_complete) {
            return redirect()->route('home');;
        } else {
            return view('pair');
        }
    }
}
