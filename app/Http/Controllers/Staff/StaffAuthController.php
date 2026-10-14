<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffAuthController extends Controller
{
    /**
     * Show Staff Login page.
     */
    public function loginForm()
    {
        if (Auth::check()) {
            if (Auth::user()->role === 'staff') {
                return redirect()->route('staff.dashboard');
            }

            Auth::logout();
        }

        return view('staff.auth.login');
    }

    /**
     * Staff Login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => [
                'required',
                'email',
            ],
            'password' => [
                'required',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Staff Login Only
        |--------------------------------------------------------------------------
        */

        $credentials['role'] = 'staff';
        $credentials['is_active'] = true;

        if (Auth::attempt($credentials, $request->boolean('remember'))) {

            $request->session()->regenerate();

            return redirect()
                ->intended(route('staff.dashboard'))
                ->with('success', 'Staff login successful.');
        }

        return back()
            ->withErrors([
                'email' =>
                    'Invalid staff login credentials or staff account is inactive.',
            ])
            ->withInput(
                $request->only('email')
            );
    }

    /**
     * Staff Logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()
            ->route('staff.login')
            ->with('success', 'You have been logged out successfully.');
    }
}