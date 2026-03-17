<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Actions\Staff\CreateStaffAction;
use App\DTO\CreateStaffDTO;
use App\Services\StaffService;

class StaffController extends Controller
{
    public function index(StaffService $staffService)
    {
        $staff = $staffService->listStaff(auth()->user()->organization_id);

        return view('staff.index', compact('staff'));
    }

    public function store(Request $request, CreateStaffAction $action)
    {
        $request->validate([
            'name' => 'required|string|max:255',

            'email' => 'required|email|unique:users,email',

            'password' => 'required|min:6',
        ], [
            // ✅ Name messages
            'name.required' => 'Staff name is required',
            'name.string' => 'Name must be a valid string',
            'name.max' => 'Name cannot exceed 255 characters',

            // ✅ Email messages
            'email.required' => 'Email is required',
            'email.email' => 'Enter a valid email address',
            'email.unique' => 'This email is already used',

            // ✅ Password messages
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