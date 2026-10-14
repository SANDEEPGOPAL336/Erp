<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\AdmissionApplication;
use Illuminate\Http\Request;

class RegistrationFormController extends Controller
{
    /**
     * Show final registration form.
     */
    public function index(Request $request)
    {
        $application = AdmissionApplication::where(
            'user_id',
            $request->user()->id
        )
        ->with([
            'course',
            'session',
            'semester',
        ])
        ->latest()
        ->first();

        if (!$application) {
            return redirect()
                ->route('student.dashboard')
                ->withErrors([
                    'application' => 'Admission application not found.'
                ]);
        }

        $profile = $request->user()->studentProfile;

        if (!$profile) {
            return redirect()
                ->route('student.personal')
                ->withErrors([
                    'profile' => 'Please complete your personal information first.'
                ]);
        }

        $qualifications = $profile->qualifications()
            ->where('is_active', true)
            ->get();

        $documents = $profile->documents()
            ->where('is_active', true)
            ->get();

        return view(
            'student.registration-form',
            compact(
                'application',
                'profile',
                'qualifications',
                'documents'
            )
        );
    }

    /**
     * Submit final registration application.
     */
    public function submit(Request $request)
    {
        $request->validate([
            'declaration' => [
                'required',
                'accepted'
            ],
        ], [
            'declaration.accepted' =>
                'You must accept the declaration before submitting the application.'
        ]);

        $application = AdmissionApplication::where(
            'user_id',
            $request->user()->id
        )
        ->with('course')
        ->latest()
        ->first();

        if (!$application) {
            return redirect()
                ->route('student.dashboard')
                ->withErrors([
                    'application' => 'Admission application not found.'
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | IMPORTANT:
        | Once submitted, student cannot submit again.
        | Student can submit again ONLY when teacher rejects it.
        |--------------------------------------------------------------------------
        */

        if ($application->status === 'submitted') {
            return redirect()
                ->route('student.registration.form')
                ->withErrors([
                    'submit' =>
                        'Your application has already been submitted and is waiting for verification. You cannot submit it again unless the Unit Teacher rejects it.'
                ]);
        }

        if ($application->status === 'approved') {
            return redirect()
                ->route('student.registration.form')
                ->withErrors([
                    'submit' =>
                        'Your application has already been approved. You cannot submit it again.'
                ]);
        }

        if (!$application->course_id) {
            return redirect()
                ->route('student.admission.course')
                ->withErrors([
                    'course_id' => 'Please select a course first.'
                ]);
        }

        $profile = $request->user()->studentProfile;

        if (!$profile) {
            return redirect()
                ->route('student.personal')
                ->withErrors([
                    'profile' =>
                        'Please complete your personal information first.'
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Check Personal Information
        |--------------------------------------------------------------------------
        */

        if (
            empty($profile->date_of_birth) ||
            empty($profile->gender) ||
            empty($profile->category) ||
            empty($profile->father_name) ||
            empty($profile->mother_name)
        ) {
            return redirect()
                ->route('student.personal')
                ->withErrors([
                    'personal' =>
                        'Please complete all required personal information before submitting.'
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Check Qualifications
        |--------------------------------------------------------------------------
        */

        $qualificationCount = $profile->qualifications()
            ->where('is_active', true)
            ->count();

        if ($qualificationCount < 1) {
            return redirect()
                ->route('student.qualifications')
                ->withErrors([
                    'qualification' =>
                        'Please add at least one educational qualification.'
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Check Documents
        |--------------------------------------------------------------------------
        */

        $documentCount = $profile->documents()
            ->where('is_active', true)
            ->count();

        if ($documentCount < 1) {
            return redirect()
                ->route('student.documents')
                ->withErrors([
                    'document' =>
                        'Please upload at least one document.'
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Submit / Re-submit
        |--------------------------------------------------------------------------
        */

        $application->status = 'submitted';
        $application->submitted_at = now();

        // Clear previous rejection information
        $application->reviewed_by = null;
        $application->review_remarks = null;
        $application->reviewed_at = null;

        $application->save();

        return redirect()
            ->route('student.dashboard')
            ->with(
                'success',
                'Your admission application has been submitted successfully and sent to the Unit Teacher for verification.'
            );
    }
}