<?php

namespace App\Http\Controllers\Auth\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Rules\Auth\MatchOldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'name' => 'required',
        //     'email' => 'required|email|unique:users',
        //     'password' => 'required',
        //     'image' => 'image|mimes:png,jpg,jpeg',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json([
        //         'status' => false,
        //         'errors' => $validator->errors(),
        //         'message' => 'Fail'
        //     ], 422);
        // }

        $request->validated();

        $user = $request->store();

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imagePath = $request->file('image');
            $imageName = ucwords(explode(" ", $user->name)[0]) . $user->id . time() . "." . $imagePath->extension();

            $path = $request->file('image')->storeAs('profiles', $imageName, 'public');

            $user->image = $imageName;
            $success = $user->save();
        }

        $token = $user->createToken('LaravelAuth')->accessToken;

        if ($success) {
            return response()->json([
                'status' => true,
                'id' => $user->id,
                'data' => $user,
                'token' => $token,
                'message' => 'Account Created'
            ], 201);
        } else {
            return response()->json([
                'status' => false,
                'errors' => [],
                'message' => 'Fail'
            ], 422);
        }
    }

    public function login(Request $request)
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
                'message' => 'Login successful'
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'errors' => [],
                "message" => "Incorrect Email and/or Password"
            ], 401);
        }
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
}
