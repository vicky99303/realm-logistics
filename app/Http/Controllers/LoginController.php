<?php

namespace App\Http\Controllers;

use App\Mail\VerifyMail;
use App\Models\User;
use App\Models\VerifyUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Console\Input\Input;

class LoginController extends Controller
{
    protected $redirectTo = 'profile';
    /**
     * Render Login View Page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        if (Auth::check() && Auth::user()->superadmin == 1) {
            return redirect(route('sdashboard'));
        } else if (Auth::check() && Auth::user()->superadmin == 0 && Auth::user()->verified ) {
            return redirect(route('dashboard'));
        } else if (Auth::check() && Auth::user()->superadmin == 0 && !Auth::user()->verified ) {
            auth()->logout();
            return back()->with('warning', 'You need to confirm your account. We have sent you an activation code, please check your email.');
        }

        $data = array(
            'title' => 'Login'
        );
        return view('welcome', $data);
    }

    /**
     * Render Register View Page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function register()
    {
        if (Auth::check() && Auth::user()->superadmin == 1) {
            return redirect(route('sdashboard'));
        } else if (Auth::check() && Auth::user()->superadmin == 0) {
            return redirect(route('dashboard'));
        }
        $data = array(
            'title' => 'Register'
        );
        return view('auth.register', $data);
    }

    public function registerpost(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:users|max:255',
            'email' => 'required|unique:users|max:255',
            'password' => 'required',
        ]);
        $user = User::create([
            'name' =>  $validated['name'],
            'email' => $validated['email'],
            'superadmin' => 0,
            'password' => Hash::make($validated['password']),
        ]);
        try {
            \DB::beginTransaction();
            $verifyUser = VerifyUser::create([
                'user_id' => $user->id,
                'token' => sha1(time())
            ]);
            \Mail::to($user->email)->send(new VerifyMail($user));
            \DB::commit();
        }catch(\Exception $exception){
            \DB::rollback();
        }

        return redirect(route('login'))->with('status', 'We sent you an activation code. Check your email and click on the link to verify.');
    }

    /**
     * @param $token
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function verifyUser($token)
    {
        $verifyUser = VerifyUser::where('token', $token)->first();
        if(isset($verifyUser) ){
            $user = $verifyUser->user;
            if(!$user->verified) {
                $verifyUser->user->verified = 1;
                $verifyUser->user->save();
                $status = "Your e-mail is verified. You can now login.";
            } else {
                $status = "Your e-mail is already verified. You can now login.";
            }
        } else {
            return redirect('/login')->with('warning', "Sorry your email cannot be identified.");
        }
        return redirect('/login')->with('status', $status);
    }

    /**
     * Handle an authentication attempt.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
        }
        return back()->withErrors([
            'emailError' => 'The provided credentials do not match our records.',
        ])->withInput();
    }

    /**
     * Log the user out of the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('login'));
    }
}
