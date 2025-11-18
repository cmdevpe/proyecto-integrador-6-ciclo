<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Contracts\MustVerifyAccount;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;

class EnsureAccountIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user instanceof MustVerifyAccount && !$user->hasVerifiedAccount()) {
            session(['email_for_verification' => $user->email]);
            return Redirect::guest(route('account.verify'));
        }

        return $next($request);
    }
}
