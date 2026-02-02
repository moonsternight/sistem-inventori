<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;

class AutentikasiController extends Controller
{
    public function login(Request $request)
    {
        $key = 'login-attempt:' . $request->ip();
        $maxAttempts = 5;
        $decaySeconds = 60;

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);
            session()->put(['error' => 'limit', 'remaining' => $seconds, 'lockout_time' => time() + $seconds]);
            session()->save();
            return back();
        }

        $pemilik = DB::table('pemilik')->first();

        if ($pemilik && Hash::check($request->pin, $pemilik->pin_hash)) {
            RateLimiter::clear($key);
            session()->forget(['error', 'remaining', 'lockout_time']);
            $request->session()->put('is_login', true);
            return redirect('/inventori')->with('success', 'Login berhasil.');
        }

        RateLimiter::hit($key, $decaySeconds);

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = $decaySeconds;
            session()->put(['error' => 'limit', 'remaining' => $seconds, 'lockout_time' => time() + $seconds]);
            session()->save();
            return back();
        }

        return back()->with('error', 'PIN salah, silakan coba lagi.');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/login');
    }
}
