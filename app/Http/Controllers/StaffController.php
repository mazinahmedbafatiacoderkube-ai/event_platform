<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Actions\Staff\CreateStaffAction;
use App\DTO\CreateStaffDTO;
use App\Services\StaffService;
use App\Models\Event;
use Illuminate\Support\Facades\Auth; // ✅ Import Auth facade

class StaffController extends Controller
{
    public function index(StaffService $staffService)
    {
        // Fetch staff for the logged-in user's organization
        $staff = $staffService->listStaff(Auth::user()->organization_id);

        // Fetch events for the same organization
        $events = Event::where('organization_id', Auth::user()->organization_id)->get();

        // Pass both $staff and $events to the view
        return view('staff.index', compact('staff', 'events'));
    }

    public function store(Request $request, CreateStaffAction $action)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ], [
            // Name validation messages
            'name.required' => 'Staff name is required',
            'name.string' => 'Name must be a valid string',
            'name.max' => 'Name cannot exceed 255 characters',

            // Email validation messages
            'email.required' => 'Email is required',
            'email.email' => 'Enter a valid email address',
            'email.unique' => 'This email is already used',

            // Password validation messages
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 6 characters',
        ]);

        $dto = CreateStaffDTO::fromRequest($request);

        $action->execute($dto);

        return redirect()->back()->with('success', 'Staff Created');
    }

    public function destroy($id, StaffService $staffService)
    {
        try {
            $staffService->deleteStaff($id);

            return redirect()->back()->with('success', 'Staff Deleted Successfully');

        } catch (\Exception $e) {
            return redirect()->back()->withErrors([
                'error' => 'Unable to delete staff. Please try again.'
            ]);
        }
    }
}