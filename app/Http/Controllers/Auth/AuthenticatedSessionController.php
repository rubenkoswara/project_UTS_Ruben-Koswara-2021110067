<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // --- MULAI MODIFIKASI UNTUK ADMIN/CUSTOMER ---
        
        if (Auth::user()->is_admin) {
            // Jika Admin, arahkan ke Dashboard Admin
            return redirect()->intended(route('admin.dashboard', absolute: false));
        }

        // Ganti 'customer.home' jika nama route Katalog Anda berbeda
        return redirect()->intended(route('customer.home', absolute: false));
        
        // --- AKHIR MODIFIKASI ---
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}