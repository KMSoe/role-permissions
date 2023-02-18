<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Laravel\Socialite\Facades\Socialite;
use Modules\Auth\Helpers\AuthHelper;
use Modules\Auth\Http\Requests\Web\LoginRequest;
use Modules\Auth\Http\Requests\Web\RegisterRequest;
use Modules\Auth\Rules\MatchOldPassword;

class AuthController extends Controller
{

    public function login()
    {
        return Inertia::render('Modules/Auth/Site/Login', []);
    }

    public function register()
    {
        return Inertia::render('Modules/Auth/Site/Register', []);
    }

    public function emailVerify($id)
    {
        $user = User::select('id', 'email')
            ->find($id);

        return Inertia::render('Modules/Auth/Site/EmailVerify', [
            'user' => $user
        ]);
    }

    public function storeEmailVerify(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp_code' => 'required'
        ]);

        $email = $request->email;
        $otp_code = $request->otp_code;

        $user = User::where('email', $email)
            ->first();

        if (!$user) {
            return back()->with('error', 'No User found');
        }

        if($user->otp_code == $otp_code) {
            if (Carbon::now()->gt($user->otp_expired_at)) {
                return back()->with('error', 'OTP code was Expired');
            } 

            $user->otp_code = null;
            $user->otp_expired_at = null;
            $user->is_verified = 1;
            $user->save();

            return Redirect::route('auth.login')->with('success', 'Account created');
        } else {
            return back()->with('error', 'OTP code is Incorrect or Expired');
        }
    }

    public function forgotPassword()
    {
        return Inertia::render('Modules/Auth/Site/ForgotPassword', []);
    }

    public function storeForgotPassword()
    {
    }

    public function storeLogin(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return Inertia::location(route('home.index'));
    }

    public function storeRegister(RegisterRequest $request)
    {
        $request->validated();
        $user = $request->store();

        AuthHelper::sendEmailVerify($user->id);

        return redirect()->route('auth.email.verify', ['id' => $user->id])->with('success', 'Account created');
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // if ($response = $this->loggedOut($request)) {
        //     return $response;
        // }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : Inertia::location("/");
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

    public function getChangePassword()
    {
        return Inertia::render('Modules/Auth/Site/ChangePassword', []);
    }

    public function storeChangePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        User::find(auth()->user()->id)->update(['password' => Hash::make($request->new_password)]);

        return Redirect::route('profile.index')->with('success', 'Password Changed Successfully');
    }

    protected function _registerOrLoginUser($data)
    {
        $user = User::where('email', $data->email)->first();

        if (!$user) {
            $user = new User();
            $user->name = $data->name;
            $user->email = $data->email;
            $user->account_id = 1;
            $user->provider_id = $data->id;
            $user->avatar = $data->avatar;
            $user->save();
        }

        Auth::login($user);
    }

    //Google Login
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    //Google callback  
    public function handleGoogleCallback()
    {

        $user = Socialite::driver('google')->user();

        $this->_registerorLoginUser($user);
        return redirect()->route('home.index');
    }

    //Facebook Login
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    //facebook callback  
    public function handleFacebookCallback()
    {

        $user = Socialite::driver('facebook')->user();

        $this->_registerorLoginUser($user);
        return redirect()->route('home.index');
    }
}
