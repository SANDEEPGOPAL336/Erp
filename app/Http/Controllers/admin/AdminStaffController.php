<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StaffProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminStaffController extends Controller
{
    private function ensureAdmin(): void
    {
        if (auth()->user()?->role !== 'admin') {
            abort(403, 'Unauthorized access.');
        }
    }

    public function index()
    {
        $this->ensureAdmin();

        $staff = StaffProfile::with('user')
            ->latest()
            ->paginate(15);

        return view('admin.staff.index', compact('staff'));
    }

    public function create()
    {
        $this->ensureAdmin();

        return view('admin.staff.create');
    }

    public function store(Request $request)
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:190', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:30'],
            'employee_code' => ['required', 'string', 'max:50', 'unique:staff_profiles,employee_code'],
            'designation' => ['required', 'string', 'max:120'],
            'joining_date' => ['nullable', 'date'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'staff',
            'phone' => $validated['phone'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ]);

        StaffProfile::create([
            'user_id' => $user->id,
            'employee_code' => $validated['employee_code'],
            'designation' => $validated['designation'],
            'joining_date' => $validated['joining_date'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.staff.index')
            ->with('success', 'Staff account created successfully.');
    }

    public function edit(StaffProfile $staff)
    {
        $this->ensureAdmin();

        $staff->load('user');

        return view('admin.staff.edit', compact('staff'));
    }

    public function update(Request $request, StaffProfile $staff)
    {
        $this->ensureAdmin();

        $staff->load('user');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => [
                'required',
                'email',
                'max:190',
                Rule::unique('users', 'email')->ignore($staff->user_id),
            ],
            'phone' => ['nullable', 'string', 'max:30'],
            'employee_code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('staff_profiles', 'employee_code')->ignore($staff->id),
            ],
            'designation' => ['required', 'string', 'max:120'],
            'joining_date' => ['nullable', 'date'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $staff->user->name = $validated['name'];
        $staff->user->email = $validated['email'];
        $staff->user->phone = $validated['phone'] ?? null;
        $staff->user->is_active = $request->boolean('is_active');

        if (!empty($validated['password'])) {
            $staff->user->password = Hash::make($validated['password']);
        }

        $staff->user->save();

        $staff->update([
            'employee_code' => $validated['employee_code'],
            'designation' => $validated['designation'],
            'joining_date' => $validated['joining_date'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.staff.index')
            ->with('success', 'Staff details updated successfully.');
    }

    public function toggle(StaffProfile $staff)
    {
        $this->ensureAdmin();

        $newStatus = !$staff->is_active;

        $staff->update([
            'is_active' => $newStatus,
        ]);

        if ($staff->user) {
            $staff->user->update([
                'is_active' => $newStatus,
            ]);
        }

        return back()->with(
            'success',
            $newStatus
                ? 'Staff account activated successfully.'
                : 'Staff account deactivated successfully.'
        );
    }
}
