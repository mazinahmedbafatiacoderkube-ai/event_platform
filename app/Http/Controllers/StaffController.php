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
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        $dto = CreateStaffDTO::fromRequest($request);

        $action->execute($dto);

        return redirect()->back()->with('success','Staff Created');
    }

    // ✅ ADD THIS METHOD
    public function destroy($id, StaffService $staffService)
    {
        $staffService->deleteStaff($id);

        return redirect()->back()->with('success','Staff Deleted Successfully');
    }
}