<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Register new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @LRDparam name required|string|max:255
     * @LRDparam email required|string|email|unique:users,email
     * @LRDparam password required|string|min:6
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()], 400);
        }
        $validatedData = $validator->valid();
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);
        //generate email verification url
        $url = URL::signedRoute(
            'verification.verify',
            ['id' => $user->id, 'hash' => sha1($user->getEmailForVerification())],
            now()->addMinutes(60), // Expiration time of the URL (in this case, 60 minutes)
        );

        // event(new Registered($user)); // Send verification email

        return response()->json(['message' => 'User registered successfully', 'verification_url' => $url], 201);
    }

    /**
     * Login user with credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     * @LRDparam email required|string|email
     * @LRDparam password required|string|min:6
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:6',
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(['errors' => ['auth' => 'credentials does not match']], 400);
        }

        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['token' => $token, 'message' => 'Logged in successfully'], 200);
    }

    /**
     * Logout Authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully'], 200);
    }

    /**
     * Get current user info.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function user(Request $request)
    {
        return $request->user();
    }
}
