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

        // [SECURITY / UX]
        // หลังล็อกอินให้แยกปลายทางตามสิทธิ์ผู้ใช้
        // - admin / executive / social_worker -> ไปหน้า dashboard
        // - role อื่นทั้งหมด -> ไปหน้า client.show
        $user = Auth::user();

        if ($user && in_array($user->role, ['admin', 'executive', 'social_worker'])) {
            // ผู้มีสิทธิ์เข้าหน้าสถิติ
            return redirect()->intended(route('dashboard', absolute: false));
        }

        // ผู้ใช้ที่ไม่มีสิทธิ์เข้าหน้าสถิติ ให้ไปหน้ารายชื่อผู้รับบริการแทน
        return redirect()->intended(route('client.show', absolute: false));
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