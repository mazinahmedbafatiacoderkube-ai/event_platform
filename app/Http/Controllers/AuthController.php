<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use App\DTO\RegisterOrganizationDTO;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\AttendeeRegistration;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function loginPage()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function registerPage()
    {
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

        // 1. Organization Login
        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            $user = Auth::user();
            $token = $user->createToken('user-token')->plainTextToken;

            return redirect()->route('dashboard')
                ->with('success', 'Login successful')
                ->with('token', $token);
        }

        // 2. Attendee Login
        $attendee = AttendeeRegistration::where('email', $validated['email'])->first();

        if ($attendee && Hash::check($validated['password'], $attendee->password)) {
            Auth::guard('attendee')->login($attendee);
            $request->session()->regenerate();

            return redirect()->route('landing') // make sure route exists
                ->with('success', 'Login successful');
        }

        // 3. Failed login
        return back()->withErrors([
            'email' => 'Invalid email or password'
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        Auth::guard('attendee')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Logged out successfully');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'organization_name' => 'required|string|max:255',
            'plan' => 'required|in:free,pro',
            'owner_name' => 'required|string|max:255',

            'owner_email' => [
                'required',
                'email',
                'unique:users,email',
                'unique:attendees,email',
                'unique:attendee_registrations,email',
            ],

            'password' => 'required|min:6|confirmed',
        ], [
            'organization_name.required' => 'Organization name is required',
            'plan.required' => 'Please select a plan',
            'plan.in' => 'Plan must be free or pro',

            'owner_name.required' => 'Owner name is required',

            'owner_email.required' => 'Email is required',
            'owner_email.email' => 'Enter a valid email',
            'owner_email.unique' => 'This email is already registered in the system',

            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 6 characters',
            'password.confirmed' => 'Passwords do not match',
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
