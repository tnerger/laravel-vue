<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function create()
    {
        return inertia('Auth/Login');
    }

    public function store(Request $request)
    {
        $authData = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        if (!Auth::attempt($authData, true)) {
            throw ValidationException::withMessages([
                'email' => 'Login failed'
            ]);
        }

        // Regenerate, weil so verhindert werden kann, dass z.B.
        // ein Link mit einer Session ID zum Login übergeben wird
        // um so den Login eines anderen Users abzugreifen
        $request->session()->regenerate();

        return redirect()->intended(route('listing.index'));
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('listing.index');
    }
}
