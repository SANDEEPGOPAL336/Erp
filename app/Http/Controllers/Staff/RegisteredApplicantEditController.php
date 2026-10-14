<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\AdmissionApplication;
use App\Models\Course;
use App\Models\Semester;
use App\Models\StudentQualification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class RegisteredApplicantEditController extends Controller
{
    private function staffAndApplication(Request $request, int $id): array
    {
        $user = $request->user();
        abort_unless($user && $user->role === 'staff', 403, 'Unauthorized access.');

        $staffProfile = $user->staffProfile;
        abort_unless($staffProfile && $staffProfile->is_active, 403, 'Active staff profile not found.');

        $assignments = $staffProfile->assignments()->where('is_active', true)->get();
        abort_if($assignments->isEmpty(), 403, 'No active academic assignments found.');

        $application = AdmissionApplication::query()
            ->with(['student.studentProfile.qualifications', 'course', 'session', 'semester'])
            ->whereKey($id)
            ->where('status', 'approved')
            ->where(function (Builder $scope) use ($assignments) {
                foreach ($assignments as $assignment) {
                    $scope->orWhere(function (Builder $pair) use ($assignment) {
                        $pair->where('course_id', $assignment->course_id)
                            ->where('academic_session_id', $assignment->academic_session_id);
                        if ($assignment->semester_id !== null) {
                            $pair->where(function (Builder $semester) use ($assignment) {
                                $semester->whereNull('semester_id')
                                    ->orWhere('semester_id', $assignment->semester_id);
                            });
                        }
                    });
                }
            })->firstOrFail();

        $this->ensureEditable($application);
        return [$staffProfile, $assignments, $application];
    }

    private function ensureEditable(AdmissionApplication $application): void
    {
        abort_unless($application->status === 'approved', 403,
            'Only teacher-approved applicants can be edited here.');

        $hasActiveEnrollment = DB::table('student_enrollments')
            ->where('admission_application_id', $application->id)
            ->where('enrollment_status', 'active')->exists();
        abort_if($hasActiveEnrollment, 403,
            'This applicant has already been enrolled and can no longer be edited here.');

        if (Schema::hasTable('student_fee_payments')) {
            $feeQuery = DB::table('student_fee_payments')
                ->where('admission_application_id', $application->id)
                ->where('installment_number', 1);
            if (Schema::hasColumn('student_fee_payments', 'status')) {
                $feeQuery->where('status', 'verified');
            }
            abort_if($feeQuery->exists(), 403,
                'The first fee has been verified. Editing is now locked.');
        }
    }

    public function edit(Request $request, int $id)
    {
        [$staffProfile, $assignments, $application] = $this->staffAndApplication($request, $id);

        $courseOptions = Course::query()
            ->whereIn('id', $assignments->pluck('course_id')->unique())
            ->where('is_active', true)->orderBy('name')->get();
        $sessionIds = $assignments->pluck('academic_session_id')->unique()->values();
        $semesterOptions = Semester::query()->where('is_active', true)
            ->when(!$assignments->contains(fn ($a) => $a->semester_id === null), function ($q) use ($assignments) {
                $q->whereIn('id', $assignments->pluck('semester_id')->filter()->unique());
            })->orderBy('semester_number')->get();

        return view('staff.registered-applicants.edit', compact(
            'staffProfile', 'assignments', 'application', 'courseOptions', 'sessionIds', 'semesterOptions'
        ));
    }

    public function update(Request $request, int $id)
    {
        [$staffProfile, $assignments, $application] = $this->staffAndApplication($request, $id);

        $allowedProfileFields = [
            'aadhaar_no', 'father_name', 'father_mobile', 'mother_name', 'mother_mobile', 'alternate_mobile',
            'date_of_birth', 'gender', 'blood_group', 'marital_status', 'category', 'sub_category', 'religion',
            'nationality', 'permanent_address', 'permanent_post_office', 'permanent_tehsil', 'permanent_district',
            'permanent_state', 'permanent_country', 'permanent_pin_code', 'same_correspondence_address',
            'correspondence_address', 'correspondence_post_office', 'correspondence_tehsil', 'correspondence_district',
            'correspondence_state', 'correspondence_country', 'correspondence_pin_code', 'irdp_bpl', 'sports_quota',
            'himachali_bonafide', 'cultural_quota', 'minority_region', 'physically_challenged', 'gap_after_12th',
            'single_girl_child', 'ncc', 'nss', 'punished', 'related_student', 'serious_illness',
            'sports_cultural_distinction',
        ];

        $rules = [
            'course_id' => ['required', 'integer', Rule::in($assignments->pluck('course_id')->unique()->values()->all())],
            'semester_id' => ['required', 'integer', 'exists:semesters,id'],
            'profile' => ['nullable', 'array'],
            'profile.aadhaar_no' => ['nullable', 'string', 'max:30'],
            'profile.father_name' => ['nullable', 'string', 'max:150'],
            'profile.father_mobile' => ['nullable', 'string', 'max:30'],
            'profile.mother_name' => ['nullable', 'string', 'max:150'],
            'profile.mother_mobile' => ['nullable', 'string', 'max:30'],
            'profile.alternate_mobile' => ['nullable', 'string', 'max:30'],
            'profile.date_of_birth' => ['nullable', 'date'],
            'profile.gender' => ['nullable', 'string', 'max:30'],
            'profile.blood_group' => ['nullable', 'string', 'max:10'],
            'profile.marital_status' => ['nullable', 'string', 'max:30'],
            'profile.category' => ['nullable', 'string', 'max:60'],
            'profile.sub_category' => ['nullable', 'string', 'max:100'],
            'profile.religion' => ['nullable', 'string', 'max:80'],
            'profile.nationality' => ['nullable', 'string', 'max:80'],
            'profile.*' => ['nullable'],
            'qualifications' => ['nullable', 'array'],
            'qualifications.*.id' => ['nullable', 'integer'],
            'qualifications.*.qualification_name' => ['nullable', 'string', 'max:100'],
            'qualifications.*.subjects_stream' => ['nullable', 'string', 'max:255'],
            'qualifications.*.university_board' => ['nullable', 'string', 'max:255'],
            'qualifications.*.board_roll_no' => ['nullable', 'string', 'max:100'],
            'qualifications.*.school_institute' => ['nullable', 'string', 'max:255'],
            'qualifications.*.result_type' => ['nullable', 'string', 'max:50'],
            'qualifications.*.passing_year' => ['nullable', 'integer', 'min:1950', 'max:' . (date('Y') + 1)],
            'qualifications.*.obtained_marks' => ['nullable', 'numeric', 'min:0'],
            'qualifications.*.total_marks' => ['nullable', 'numeric', 'gt:0'],
            'qualifications.*.percentage' => ['nullable', 'numeric', 'min:0', 'max:100'],
        ];
        foreach (['permanent_address','permanent_post_office','permanent_tehsil','permanent_district','permanent_state','permanent_country','permanent_pin_code','correspondence_address','correspondence_post_office','correspondence_tehsil','correspondence_district','correspondence_state','correspondence_country','correspondence_pin_code'] as $field) {
            $rules['profile.' . $field] = ['nullable', 'string', 'max:255'];
        }

        $data = $request->validate($rules);
        $selectedSemester = Semester::whereKey($data['semester_id'])->where('is_active', true)->firstOrFail();
        $course = Course::whereKey($data['course_id'])->where('is_active', true)->firstOrFail();

        $matchingAssignment = $assignments->first(function ($a) use ($course, $application, $selectedSemester) {
            return (int) $a->course_id === (int) $course->id
                && (int) $a->academic_session_id === (int) $application->academic_session_id
                && ($a->semester_id === null || (int) $a->semester_id === (int) $selectedSemester->id);
        });
        abort_unless($matchingAssignment, 403,
            'You are not assigned to this course, academic session, and semester.');

        $profile = $application->student?->studentProfile;
        abort_unless($profile, 422, 'Student profile was not found.');

        DB::transaction(function () use ($application, $course, $selectedSemester, $profile, $data, $allowedProfileFields) {
            // Recheck lock conditions inside the transaction to reduce race conditions.
            $this->ensureEditable($application);

            $application->course_id = $course->id;
            $application->semester_id = $selectedSemester->id;
            $application->save();

            $profileData = $data['profile'] ?? [];
            $profile->fill(array_intersect_key($profileData, array_flip($allowedProfileFields)));
            $profile->course_id = $course->id;
            $profile->save();

            foreach (($data['qualifications'] ?? []) as $row) {
                $fields = [
                    'qualification_name', 'subjects_stream', 'university_board', 'board_roll_no',
                    'school_institute', 'result_type', 'passing_year', 'obtained_marks', 'total_marks', 'percentage',
                ];
                $qualificationData = array_intersect_key($row, array_flip($fields));
                if (!empty($row['id'])) {
                    $qualification = StudentQualification::where('student_profile_id', $profile->id)
                        ->whereKey($row['id'])->where('is_active', true)->first();
                    abort_unless($qualification, 422, 'A qualification record is invalid. Refresh the page and try again.');
                    $qualification->fill($qualificationData)->save();
                } elseif (collect($qualificationData)->contains(fn ($value) => $value !== null && $value !== '')) {
                    $profile->qualifications()->create($qualificationData + ['is_active' => true]);
                }
            }
        });

        return redirect()->route('staff.registered-applicants.index', [
            'session_id' => $application->academic_session_id,
            'course_id' => $application->course_id,
            'semester_id' => $application->semester_id,
            'year_number' => max(1, (int) ceil(($selectedSemester->semester_number ?? 1) / 2)),
        ])->with('success', 'Applicant details updated successfully.');
    }
}
