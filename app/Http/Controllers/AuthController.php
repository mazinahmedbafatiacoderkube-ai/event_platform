<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use App\DTO\RegisterOrganizationDTO;
use App\DTO\LoginUserDTO;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function loginPage()
    {
        // ✅ if already logged in redirect to dashboard
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function registerPage()
    {
        // ✅ if already logged in redirect to dashboard
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.register');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $dto = new LoginUserDTO(
            $validated['email'],
            $validated['password']
        );

        $this->authService->login($dto);

        // ✅ prevents session conflicts
        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'organization_name' => 'required|string|max:255',
            'plan' => 'required|in:free,pro',
            'owner_name' => 'required|string|max:255',
            'owner_email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed'
        ]);

        $dto = new RegisterOrganizationDTO(
            $validated['organization_name'],
            $validated['plan'],
            $validated['owner_name'],
            $validated['owner_email'],
            $validated['password']
        );

        $this->authService->registerOrganization($dto);

        return back()->with('success', 'Organization registered successfully');
    }
}