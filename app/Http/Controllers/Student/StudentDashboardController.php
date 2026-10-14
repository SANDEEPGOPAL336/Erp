<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\AdmissionApplication;
use Illuminate\Http\Request;

class StudentDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // Make sure only student users can access this page
        if ($user->role !== 'student') {
            abort(403, 'Unauthorized access.');
        }

        $application = AdmissionApplication::where(
            'user_id',
            $user->id
        )
        ->with([
            'course',
            'session',
            'semester',
        ])
        ->latest()
        ->first();

        $profile = $user->studentProfile;

        return view(
            'student.dashboard',
            compact(
                'application',
                'profile'
            )
        );
    }
}