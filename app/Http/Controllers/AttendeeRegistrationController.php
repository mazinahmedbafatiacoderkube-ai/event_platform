<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DTO\AttendeeRegistrationDTO;
use App\Actions\AttendeeRegistrationAction;

class AttendeeRegistrationController extends Controller
{
    public function show()
    {
        return view('attendees.register');
    }

    public function store(Request $request, AttendeeRegistrationAction $action)
    {
        $request->validate([
            'name' => 'required|string|max:255',

            'email' => [
                'required',
                'email',
                'unique:attendee_registrations,email',
                'unique:attendees,email',
                'unique:users,email',
            ],

            'password' => 'required|min:6|confirmed',
        ], [
            // ✅ Name errors
            'name.required' => 'Name is required',
            'name.string' => 'Name must be a valid string',
            'name.max' => 'Name cannot exceed 255 characters',

            // ✅ Email errors
            'email.required' => 'Email is required',
            'email.email' => 'Enter a valid email address',
            'email.unique' => 'This email is already registered in the system',

            // ✅ Password errors
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 6 characters',
            'password.confirmed' => 'Passwords do not match',
        ]);

        try {
            $dto = new AttendeeRegistrationDTO($request->all());

            $action->execute($dto);

            return redirect()->route('login')
                ->with('success', 'Attendee registered successfully!');

        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => $e->getMessage()
            ]);
        }
    }
}