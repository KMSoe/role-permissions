<?php

namespace Modules\Auth\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;
use Laravel\Socialite\Facades\Socialite;
use Modules\Auth\Helpers\AuthHelper;
use Modules\Auth\Http\Requests\Api\EmailLoginRequest;
use Modules\Auth\Http\Requests\Api\PhoneLoginRequest;
use Modules\Auth\Http\Requests\Api\RegisterRequest;
use Modules\Auth\Http\Resources\AuthCollection;
use Modules\Auth\Http\Resources\AuthResource;
use Modules\Auth\Rules\MatchOldPassword;

class AuthController extends Controller
{
    public function loginWithEmail(EmailLoginRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
                'message' => 'Please Fill out the required fields'
            ], 422);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = $request->user();

            // Logout from other devices
            // $token = $request->user()->token();
            // $tokens = $request->user()->tokens->pluck('id');
            // Token::whereIn('id', $tokens)->update(['revoked' => true]);
            // RefreshToken::whereIn('access_token_id', $tokens)->update(['revoked' => true]);
            // $token->revoke();

            $token = $user->createToken('LaravelAuth')->accessToken;

            return response()->json([
                'status' => true,
                'id' => $user->id,
                'token' => $token,
                'data' => $user,
                'message' => 'Login statusful'
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'errors' => [],
                "message" => "Incorrect Email and/or Password"
            ], 401);
        }
    }


    public function loginWithPhone(PhoneLoginRequest $request)
    {
    }

    public function phoneOtpVerify(Request $request)
    {
    }

    public function register(RegisterRequest $request)
    {
    }

    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $tokens = $request->user()->tokens->pluck('id');
        Token::whereIn('id', $tokens)->update(['revoked' => true]);
        RefreshToken::whereIn('access_token_id', $tokens)->update(['revoked' => true]);
        $token->revoke();

        return response()->json([], 204);
    }

    public function deleteUser()
    {
        $user = Auth::user();
        $user = User::find($user->id);
        $user->delete();

        return response()->json([], 204);
    }

    public function getUser(Request $request)
    {
        $user = Auth::user();

        return response()->json([
            "status" => true,
            "data" => $user,
            "message" => ""
        ], 200);
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required', 'min:6'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Fail',
                'errors' => $validator->getMessageBag()
            ], 422);
        }

        User::find(auth()->user()->id)->update(['password' => Hash::make($request->new_password)]);

        return response()->json([
            'status' => true,
            'message' => 'Password Changed statusfully'
        ], 200);
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
    // public function redirectToGoogle()
    // {
    //     return Socialite::driver('google')->redirect();
    // }

    //Google callback  
    // public function handleGoogleCallback()
    // {

    //     $user = Socialite::driver('google')->user();

    //     $this->_registerorLoginUser($user);
    //     return redirect()->route('home.index');
    // }

    //Facebook Login
    // public function redirectToFacebook()
    // {
    //     return Socialite::driver('facebook')->redirect();
    // }

    //facebook callback  
    // public function handleFacebookCallback()
    // {

    //     $user = Socialite::driver('facebook')->user();

    //     $this->_registerorLoginUser($user);
    //     return redirect()->route('home.index');
    // }
}
