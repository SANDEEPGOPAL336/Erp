<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\StudentQualification;
use Illuminate\Http\Request;

class QualificationController extends Controller
{
    public function index(Request $request)
    {
        $profile = $request->user()->studentProfile;

        if (!$profile) {
            abort(404, 'Student profile not found.');
        }

        $qualifications = StudentQualification::where(
            'student_profile_id',
            $profile->id
        )
        ->where('is_active', true)
        ->orderByDesc('passing_year')
        ->get();

        return view(
            'student.qualifications',
            compact('profile', 'qualifications')
        );
    }

    public function store(Request $request)
    {
        $profile = $request->user()->studentProfile;

        if (!$profile) {
            abort(404, 'Student profile not found.');
        }

        $data = $request->validate([
            'qualification_name' => [
                'required',
                'string',
                'max:150',
            ],

            'subjects_stream' => [
                'required',
                'string',
                'max:255',
            ],

            'university_board' => [
                'required',
                'string',
                'max:255',
            ],

            'board_roll_no' => [
                'required',
                'string',
                'max:100',
            ],

            'school_institute' => [
                'required',
                'string',
                'max:255',
            ],

            'result_type' => [
                'required',
                'string',
                'max:100',
            ],

            'passing_year' => [
                'required',
                'integer',
                'min:1900',
                'max:' . date('Y'),
            ],

            'obtained_marks' => [
                'required',
                'numeric',
                'min:0',
            ],

            'total_marks' => [
                'required',
                'numeric',
                'min:0',
            ],
        ]);

        if (
            (float) $data['obtained_marks'] >
            (float) $data['total_marks']
        ) {
            return back()
                ->withErrors([
                    'obtained_marks' =>
                        'Obtained marks cannot be greater than total marks.'
                ])
                ->withInput();
        }

        $data['percentage'] =
            round(
                (
                    $data['obtained_marks'] /
                    $data['total_marks']
                ) * 100,
                2
            );

        $data['student_profile_id'] = $profile->id;
        $data['is_active'] = true;

        StudentQualification::create($data);

        return redirect()
            ->route('student.qualifications')
            ->with(
                'success',
                'Qualification added successfully.'
            );
    }

    public function edit(
        Request $request,
        StudentQualification $qualification
    ) {
        $profile = $request->user()->studentProfile;

        abort_unless(
            $qualification->student_profile_id === $profile->id,
            403
        );

        return view(
            'student.qualification-edit',
            compact(
                'qualification',
                'profile'
            )
        );
    }

    public function update(
        Request $request,
        StudentQualification $qualification
    ) {
        $profile = $request->user()->studentProfile;

        abort_unless(
            $qualification->student_profile_id === $profile->id,
            403
        );

        $data = $request->validate([
            'qualification_name' => [
                'required',
                'string',
                'max:150',
            ],

            'subjects_stream' => [
                'required',
                'string',
                'max:255',
            ],

            'university_board' => [
                'required',
                'string',
                'max:255',
            ],

            'board_roll_no' => [
                'required',
                'string',
                'max:100',
            ],

            'school_institute' => [
                'required',
                'string',
                'max:255',
            ],

            'result_type' => [
                'required',
                'string',
                'max:100',
            ],

            'passing_year' => [
                'required',
                'integer',
                'min:1900',
                'max:' . date('Y'),
            ],

            'obtained_marks' => [
                'required',
                'numeric',
                'min:0',
            ],

            'total_marks' => [
                'required',
                'numeric',
                'min:0',
            ],
        ]);

        if (
            (float) $data['obtained_marks'] >
            (float) $data['total_marks']
        ) {
            return back()
                ->withErrors([
                    'obtained_marks' =>
                        'Obtained marks cannot be greater than total marks.'
                ])
                ->withInput();
        }

        $data['percentage'] =
            round(
                (
                    $data['obtained_marks'] /
                    $data['total_marks']
                ) * 100,
                2
            );

        $qualification->update($data);

        return redirect()
            ->route('student.qualifications')
            ->with(
                'success',
                'Qualification updated successfully.'
            );
    }

    public function disable(
        Request $request,
        StudentQualification $qualification
    ) {
        $profile = $request->user()->studentProfile;

        abort_unless(
            $qualification->student_profile_id === $profile->id,
            403
        );

        $qualification->update([
            'is_active' => false,
        ]);

        return back()->with(
            'success',
            'Qualification disabled.'
        );
    }
}