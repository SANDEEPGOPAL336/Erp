<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StaffPermission;
use App\Models\StaffProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminStaffPermissionController extends Controller
{
    /**
     * Permission catalogue used throughout the ERP.
     *
     * Keep these keys stable because staff routes and menu checks
     * use the same permission_key values.
     */
    private function permissionCatalogue(): array
    {
        return [
            [
                'key' => 'new_applicants',
                'label' => 'New Applicants',
                'description' => 'View and verify newly submitted admission applications.',
                'icon' => '📝',
                'group' => 'Admission',
            ],
            [
                'key' => 'registered_applicants',
                'label' => 'Registered Applicants',
                'description' => 'View students whose registration/enrollment is completed.',
                'icon' => '🎓',
                'group' => 'Admission',
            ],
            [
                'key' => 'manage_attendance',
                'label' => 'Manage Attendance',
                'description' => 'Enter and manage attendance for assigned students.',
                'icon' => '📊',
                'group' => 'Academic',
            ],
            [
                'key' => 'previous_attendance',
                'label' => 'Previous Attendance Files',
                'description' => 'View previous attendance records and files.',
                'icon' => '📁',
                'group' => 'Academic',
            ],
            [
                'key' => 'readmission',
                'label' => 'Readmission',
                'description' => 'Process eligible readmission cases.',
                'icon' => '🔄',
                'group' => 'Admission',
            ],
            [
                'key' => 'house_exams',
                'label' => 'House Exams',
                'description' => 'Manage internal/house examination work.',
                'icon' => '📋',
                'group' => 'Examination',
            ],
            [
                'key' => 'marksheet_management',
                'label' => 'Marksheet Management',
                'description' => 'Enter, review and manage examination marksheets.',
                'icon' => '📑',
                'group' => 'Examination',
            ],
            [
                'key' => 'fee_concession',
                'label' => 'Fee Concession',
                'description' => 'Process approved student fee concessions.',
                'icon' => '💳',
                'group' => 'Finance',
            ],
            [
                'key' => 'online_fee_verification',
                'label' => 'Online Fee Verification',
                'description' => 'Verify online fee payment records.',
                'icon' => '💻',
                'group' => 'Finance',
            ],
            [
                'key' => 'offline_fee_verification',
                'label' => 'Offline Fee Verification',
                'description' => 'Verify offline/cash fee payment records.',
                'icon' => '🧾',
                'group' => 'Finance',
            ],
            [
                'key' => 'course_program_change',
                'label' => 'Course / Program Change',
                'description' => 'Process student course or programme change requests.',
                'icon' => '🔁',
                'group' => 'Student Services',
            ],
            [
                'key' => 'university_data',
                'label' => 'University Data',
                'description' => 'Access approved university data and submission work.',
                'icon' => '🏛️',
                'group' => 'University',
            ],
        ];
    }

    public function index()
    {
        abort_unless(
            auth()->check() &&
            auth()->user()->role === 'admin',
            403
        );

        $staffProfiles = StaffProfile::with('user')
            ->where('is_active', true)
            ->orderBy('employee_code')
            ->get();

        $permissionCatalogue = $this->permissionCatalogue();

        return view(
            'admin.staff-permissions.index',
            compact(
                'staffProfiles',
                'permissionCatalogue'
            )
        );
    }

    public function edit(StaffProfile $staffProfile)
    {
        abort_unless(
            auth()->check() &&
            auth()->user()->role === 'admin',
            403
        );

        $staffProfile->load('user', 'permissions');

        $permissionCatalogue = $this->permissionCatalogue();

        $existingPermissions = $staffProfile
            ->permissions
            ->keyBy('permission_key');

        return view(
            'admin.staff-permissions.edit',
            compact(
                'staffProfile',
                'permissionCatalogue',
                'existingPermissions'
            )
        );
    }

    public function update(
        Request $request,
        StaffProfile $staffProfile
    ) {
        abort_unless(
            auth()->check() &&
            auth()->user()->role === 'admin',
            403
        );

        $catalogueKeys = collect($this->permissionCatalogue())
            ->pluck('key')
            ->values()
            ->all();

        $validated = $request->validate([
            'permissions' => [
                'nullable',
                'array',
            ],
            'permissions.*' => [
                'string',
                'in:' . implode(',', $catalogueKeys),
            ],
            'start_date' => [
                'nullable',
                'date',
            ],
            'end_date' => [
                'nullable',
                'date',
                'after_or_equal:start_date',
            ],
        ]);

        $selectedPermissions = collect(
            $validated['permissions'] ?? []
        )->unique()->values();

        DB::transaction(function () use (
            $staffProfile,
            $selectedPermissions,
            $validated,
            $catalogueKeys
        ) {
            foreach ($catalogueKeys as $permissionKey) {

                $isSelected =
                    $selectedPermissions
                        ->contains($permissionKey);

                StaffPermission::updateOrCreate(
                    [
                        'staff_profile_id' => $staffProfile->id,
                        'permission_key' => $permissionKey,
                    ],
                    [
                        'start_date' =>
                            $isSelected
                                ? ($validated['start_date'] ?? null)
                                : null,

                        'end_date' =>
                            $isSelected
                                ? ($validated['end_date'] ?? null)
                                : null,

                        'is_active' => $isSelected,
                    ]
                );
            }
        });

        return redirect()
            ->route(
                'admin.staff-permissions.edit',
                $staffProfile
            )
            ->with(
                'success',
                'Staff permissions updated successfully.'
            );
    }
}
