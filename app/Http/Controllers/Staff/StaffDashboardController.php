<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\AdmissionApplication;
use App\Models\StaffAssignment;
use App\Models\StaffProfile;
use Illuminate\Http\Request;

class StaffDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        /*
        |--------------------------------------------------------------------------
        | Staff Access Check
        |--------------------------------------------------------------------------
        */

        if ($user->role !== 'staff') {
            abort(403, 'Unauthorized access.');
        }


        /*
        |--------------------------------------------------------------------------
        | Staff Profile
        |--------------------------------------------------------------------------
        */

        $staffProfile = StaffProfile::where('user_id', $user->id)
            ->where('is_active', true)
            ->first();

        if (!$staffProfile) {
            abort(403, 'Staff profile not found.');
        }


        /*
        |--------------------------------------------------------------------------
        | Active Assignments
        |--------------------------------------------------------------------------
        */

        $assignments = StaffAssignment::where(
            'staff_profile_id',
            $staffProfile->id
        )
        ->where('is_active', true)
        ->get();


        /*
        |--------------------------------------------------------------------------
        | Assigned Course / Session IDs
        |--------------------------------------------------------------------------
        */

        $courseIds = $assignments
            ->pluck('course_id')
            ->filter()
            ->unique()
            ->values();

        $sessionIds = $assignments
            ->pluck('academic_session_id')
            ->filter()
            ->unique()
            ->values();


        /*
        |--------------------------------------------------------------------------
        | Base Application Query
        |--------------------------------------------------------------------------
        */

        $baseQuery = AdmissionApplication::query();


        // Restrict to assigned courses
        if ($courseIds->isNotEmpty()) {

            $baseQuery->whereIn(
                'course_id',
                $courseIds
            );

        } else {

            $baseQuery->whereRaw('1 = 0');

        }


        // Restrict to assigned academic sessions
        if ($sessionIds->isNotEmpty()) {

            $baseQuery->whereIn(
                'academic_session_id',
                $sessionIds
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Dashboard Statistics
        |--------------------------------------------------------------------------
        */

        $totalApplicants = (clone $baseQuery)
            ->count();


        $newApplicants = (clone $baseQuery)
            ->where('status', 'submitted')
            ->count();


        $approvedApplications = (clone $baseQuery)
            ->where('status', 'approved')
            ->count();


        $rejectedApplications = (clone $baseQuery)
            ->where('status', 'rejected')
            ->count();


        $draftApplications = (clone $baseQuery)
            ->where('status', 'draft')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | Recent Applications
        |--------------------------------------------------------------------------
        */

        $recentApplications = (clone $baseQuery)
            ->with([
                'student',
                'course',
                'session',
                'semester'
            ])
            ->latest('updated_at')
            ->take(8)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Dashboard View
        |--------------------------------------------------------------------------
        */

        return view(
            'staff.dashboard',
            compact(
                'staffProfile',
                'assignments',
                'totalApplicants',
                'newApplicants',
                'approvedApplications',
                'rejectedApplications',
                'draftApplications',
                'recentApplications'
            )
        );
    }
}