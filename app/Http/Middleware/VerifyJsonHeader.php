<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyJsonHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // if (
        //     !$request->expectsJson() ||
        //     !$request->isJson() ||
        //     !$request->header('Accept') ||
        //     $request->header('Accept') != 'application/json'
        //     || !$request->header('Content-Type') ||
        //     $request->header('Content-Type') != 'application/json'
        // ) {

        //     return response()->json(['error' => 'Unsupported Media Type. Please send JSON and add Accept header with application/json value.'], 415);
        // }
        $request->headers->set('Accept', 'application/json');
        // $request->headers->set('Content-Type', 'application/json');
        return $next($request);
    }
}
