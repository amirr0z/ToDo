<?php

namespace App\Http\Controllers;

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
    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();

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
        //mail config
        // $request->user()->sendEmailVerificationNotification();
        // return response()->json(['message' => 'Verification email sent successfully'], 200);


        // Generate a signed verification URL
        $user = $request->user();
        $url = URL::signedRoute(
            'verification.verify',
            ['id' => $user->id, 'hash' => sha1($user->getEmailForVerification())],
            now()->addMinutes(60), // Expiration time of the URL (in this case, 60 minutes)
        );

        return response()->json(['verification_url' => $url]);
    }
}
