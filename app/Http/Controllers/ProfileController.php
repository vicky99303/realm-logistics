<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    /**
     * Render profile page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $data = array(
            'title' => 'Profile'
        );
        return view('adminpanel.profile', $data);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function profile_update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'password' => 'required',
            'address1' => 'required',
            'address2' => 'required',
            'profile_img' => 'required|mimes:png,jpg,jpeg|max:2048',
            'city' => 'required',
            'zip' => 'required',
        ]);
        $user = User::where('id', Auth::user()->id)->firstorfail();
        $user->name = $request->name;
        $user->password = Hash::make($request->password);
        $user->address1 = $request->address1;
        $user->address2 = $request->address2;
        $user->city = $request->city;
        $user->zip = $request->zip;
        if($request->hasFile('profile_img')) {
            $user->profile_img = $request->file('profile_img')->store('adminpanel/images/profile');
        }
        $user->save();
        return back()->with('status', 'Profile updated!');
    }
}
