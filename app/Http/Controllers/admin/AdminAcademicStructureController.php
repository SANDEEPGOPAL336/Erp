<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\ProgramGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminAcademicStructureController extends Controller
{
    /**
     * Complete Academic / Programme Summary.
     *
     * Default:
     * Shows ALL Program Groups in one place.
     *
     * Optional:
     * ?group=ID filters one Program Group.
     */
    public function index(Request $request)
    {
        $programGroups = ProgramGroup::with([
            'departments' => function ($query) {
                $query->where('is_active', true)
                    ->orderBy('name');
            },

            'departments.subDepartments' => function ($query) {
                $query->where('is_active', true)
                    ->orderBy('name');
            },

            'departments.subDepartments.courses' => function ($query) {
                $query->where('is_active', true)
                    ->orderBy('name');
            },

            'departments.subDepartments.courses.years' => function ($query) {
                $query->where('is_active', true)
                    ->orderBy('year_number');
            },

            'departments.subDepartments.courses.years.semesters.semester',
        ])
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Optional Program Group Filter
        |--------------------------------------------------------------------------
        */

        $selectedGroupId = $request->integer('group');

        if ($selectedGroupId > 0) {
            $programGroups = $programGroups
                ->filter(function ($group) use ($selectedGroupId) {
                    return $group->id === $selectedGroupId;
                })
                ->values();
        }

        /*
        |--------------------------------------------------------------------------
        | Overall Summary Counts
        |--------------------------------------------------------------------------
        */

        $allGroups = ProgramGroup::where('is_active', true)
            ->with([
                'departments' => function ($query) {
                    $query->where('is_active', true);
                },
                'departments.subDepartments' => function ($query) {
                    $query->where('is_active', true);
                },
                'departments.subDepartments.courses' => function ($query) {
                    $query->where('is_active', true);
                },
            ])
            ->get();

        $totalGroups = $allGroups->count();

        $totalDepartments = $allGroups
            ->sum(function ($group) {
                return $group->departments->count();
            });

        $totalSubDepartments = $allGroups
            ->sum(function ($group) {
                return $group->departments->sum(function ($department) {
                    return $department->subDepartments->count();
                });
            });

        $totalProgrammes = $allGroups
            ->sum(function ($group) {
                return $group->departments->sum(function ($department) {
                    return $department->subDepartments->sum(function ($subDepartment) {
                        return $subDepartment->courses->count();
                    });
                });
            });

        $configuredProgrammes = Course::where('is_active', true)
            ->whereNotNull('study_pattern')
            ->whereNotNull('total_years')
            ->count();

        return view(
            'admin.academic-structure.index',
            compact(
                'programGroups',
                'selectedGroupId',
                'totalGroups',
                'totalDepartments',
                'totalSubDepartments',
                'totalProgrammes',
                'configuredProgrammes'
            )
        );
    }

    /**
     * Programme academic structure editor.
     */
    public function editCourse(Course $course)
    {
        $course->load([
            'department.programGroup',
            'subDepartment',
            'years.semesters.semester',
        ]);

        return view(
            'admin.academic-structure.course-edit',
            compact('course')
        );
    }

    /**
     * Save programme academic structure.
     */
    public function updateCourse(
        Request $request,
        Course $course
    ) {
        $validated = $request->validate([
            'study_pattern' => [
                'required',
                'in:yearly,semester',
            ],

            'total_years' => [
                'required',
                'integer',
                'min:1',
                'max:8',
            ],
        ]);

        $studyPattern = $validated['study_pattern'];
        $totalYears = (int) $validated['total_years'];

        DB::transaction(function () use (
            $course,
            $studyPattern,
            $totalYears
        ) {

            /*
            |--------------------------------------------------------------------------
            | Update Programme
            |--------------------------------------------------------------------------
            */

            $course->update([
                'study_pattern' => $studyPattern,
                'total_years' => $totalYears,
            ]);


            /*
            |--------------------------------------------------------------------------
            | Create Years
            |--------------------------------------------------------------------------
            */

            for (
                $yearNumber = 1;
                $yearNumber <= $totalYears;
                $yearNumber++
            ) {

                $year = $course->years()->updateOrCreate(
                    [
                        'year_number' => $yearNumber,
                    ],
                    [
                        'name' => $this->yearName($yearNumber),
                        'is_active' => true,
                        'sort_order' => $yearNumber,
                    ]
                );


                /*
                |--------------------------------------------------------------------------
                | Yearly Programme
                |--------------------------------------------------------------------------
                */

                if ($studyPattern === 'yearly') {

                    $year->semesters()->delete();

                    continue;
                }


                /*
                |--------------------------------------------------------------------------
                | Semester-wise Programme
                |--------------------------------------------------------------------------
                |
                | Year 1 = Semester 1, 2
                | Year 2 = Semester 3, 4
                | Year 3 = Semester 5, 6
                | Year 4 = Semester 7, 8
                |
                */

                $firstSemesterNumber =
                    (($yearNumber - 1) * 2) + 1;

                $secondSemesterNumber =
                    $firstSemesterNumber + 1;


                $semesterIds = DB::table('semesters')
                    ->whereIn(
                        'semester_number',
                        [
                            $firstSemesterNumber,
                            $secondSemesterNumber,
                        ]
                    )
                    ->pluck(
                        'id',
                        'semester_number'
                    );


                if (
                    ! $semesterIds->has(
                        $firstSemesterNumber
                    )
                    ||
                    ! $semesterIds->has(
                        $secondSemesterNumber
                    )
                ) {
                    throw new \RuntimeException(
                        "Required semesters {$firstSemesterNumber} and {$secondSemesterNumber} are not available."
                    );
                }


                $year->semesters()->delete();


                $year->semesters()->createMany([
                    [
                        'semester_id' =>
                            $semesterIds[$firstSemesterNumber],

                        'is_active' => true,
                    ],

                    [
                        'semester_id' =>
                            $semesterIds[$secondSemesterNumber],

                        'is_active' => true,
                    ],
                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | Disable Old Years
            |--------------------------------------------------------------------------
            */

            $course->years()
                ->where(
                    'year_number',
                    '>',
                    $totalYears
                )
                ->update([
                    'is_active' => false,
                ]);
        });


        return redirect()
            ->route(
                'admin.academic-structure.index',
                [
                    'group' =>
                        optional(
                            $course->department
                        )->program_group_id,
                ]
            )
            ->with(
                'success',
                $course->name .
                ' academic structure updated successfully.'
            );
    }

    /**
     * Academic year display name.
     */
    private function yearName(
        int $number
    ): string {

        return match ($number) {

            1 => '1st Year',

            2 => '2nd Year',

            3 => '3rd Year',

            4 => '4th Year',

            5 => '5th Year',

            6 => '6th Year',

            7 => '7th Year',

            8 => '8th Year',

            default =>
                $number . 'th Year',
        };
    }
}