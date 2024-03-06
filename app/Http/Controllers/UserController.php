<?php

namespace App\Http\Controllers;

use App\Models\Journey;
use App\Models\Tracker;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $dataCoupon = User::where('superadmin', 0)->get();
        $data = array(
            'title' => 'User',
            'dataCoupon' => $dataCoupon
        );
        return view('adminpanel.user', $data);
    }

    public function journey($userid)
    {
        $dataCoupon = Journey::latest()->where('RiderID', $userid)->get();
        $data = array(
            'title' => 'Journey',
            'dataCoupon' => $dataCoupon
        );
        return view('adminpanel.journey', $data);
    }

    public function riderTracker($userid, $journeyId)
    {
        $data = array('userid'=>$userid,'journeyId'=>$journeyId);
        return view('tracker',$data);
    }

    public function MapData(Request $request)
    {
        if ($request->ajax()) {
            $response['data'] = Tracker::where('journeyID',$request->input('journey'))
                ->where('RiderID',$request->input('rider'))
                ->get();
            return response()->json(array($response));
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:users|max:255',
            'email' => 'required|unique:users|max:255',
            'password' => 'required',
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->superadmin = 0;
        $user->password = Hash::make($request['password']);
        $user->created_at = date('Y-m-d h:m:s');
        $user->updated_at = date('Y-m-d h:m:s');
        $user->save();
        return redirect()->back()->with('message', 'IT WORKS!');
    }

    /**
     * @param Request $request
     */
    public function lockUser(Request $request)
    {
        $user = User::find($request->id);
        $user->active = 0;
        $user->updated_at = date('Y-m-d h:m:s');
        $user->save();
    }

    /**
     * @param Request $request
     */
    public function unlockUser(Request $request)
    {
        $user = User::find($request->id);
        $user->active = 1;
        $user->updated_at = date('Y-m-d h:m:s');
        $user->save();
    }

}
