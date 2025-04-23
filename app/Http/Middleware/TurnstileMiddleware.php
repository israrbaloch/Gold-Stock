<?php

namespace App\Http\Middleware;

use Closure;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class TurnstileMiddleware {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next) {
        $turnstileResponse = $request->input('cf-turnstile-response');

        if (!$turnstileResponse) {
            return redirect()->back()->withErrors(['turnstile' => 'Validation failed.']);
        }

        $client = new Client();
        $response = $client->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
            'form_params' => [
                'secret' => config('services.cloudflare.turnstile_secret_key'),
                'response' => $turnstileResponse,
                'remoteip' => $request->ip(),
                'idempotency_key' => $request->session()->getId()
            ]
        ]);

        $result = json_decode($response->getBody());

        if (!$result->success) {
            return redirect()->back()->withErrors(['turnstile' => 'Human verification failed.']);
        }

        return $next($request);
    }
}
