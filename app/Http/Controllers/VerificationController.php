<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class VerificationController extends Controller
{

    /**
     * Verify user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function verify($id, $hash)
    {
        //get user
        $user = User::findOrFail($id);
        //check if veirfied
        if ($user->hasVerifiedEmail())
            return response()->json(['message' => 'Already verified!'], 400);


        //make sure hash belongs to this user
        if (!hash_equals(sha1($user->getEmailForVerification()), (string) $hash)) {
            return response()->json(['message' => 'Hash signature is not a match'], 400);
        }

        $user->markEmailAsVerified();

        return response()->json(['message' => 'Email verified successfully'], 200);
    }

    /**
     * Resend Verify Email.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resend(Request $request)
    {
        //check if veirfied
        if ($request->user()->hasVerifiedEmail())
            return response()->json(['message' => 'Already verified!'], 400);
        //mail
        $request->user()->sendEmailVerificationNotification();
        return response()->json(['message' => 'Verification email sent successfully'], 200);
    }
}
