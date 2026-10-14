<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\AdmissionApplication;

use App\Models\Course;

use App\Models\ProgramGroup;

use App\Models\User;

use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller

{

    public function index()

    {

        /*

        |--------------------------------------------------------------------------

        | ADMIN ACCESS

        |--------------------------------------------------------------------------

        */

        if (

            ! auth()->check()

            || auth()->user()->role !== 'admin'

       ) {

            abort(403, 'Unauthorized access.');

        }

        /*

        |--------------------------------------------------------------------------

        | ACTIVE ACADEMIC SESSION

        |--------------------------------------------------------------------------

        */

        $activeSession = DB::table('academic_sessions')

            ->where('is_active', true)

            ->orderByDesc('start_date')

            ->first();

        $activeSessionId = $activeSession?->id;

        $activeSessionName =

            $activeSession?->name ?? '2026-27';

        /*

        |--------------------------------------------------------------------------

        | TOP DASHBOARD COUNTS

        |--------------------------------------------------------------------------

        */

        $totalStudents = User::where('role', 'student')

            ->where('is_active', true)

            ->count();

        $totalStaff = User::where('role', 'staff')

            ->where('is_active', true)

            ->count();

        $totalCourses = Course::where('is_active', true)

            ->count();

        $totalApplications =

            AdmissionApplication::count();

        $todayApplications =

            AdmissionApplication::whereDate(

                'created_at',

                today()

           )->count();

        $submittedApplications =

            AdmissionApplication::where(

                'status',

                'submitted'

           )->count();

        $approvedApplications =

            AdmissionApplication::where(

                'status',

                'approved'

           )->count();

        $rejectedApplications =

            AdmissionApplication::where(

                'status',

                'rejected'

           )->count();

        /*

        |--------------------------------------------------------------------------

        | RECENT APPLICATIONS

        |--------------------------------------------------------------------------

        */

        $recentApplications =

            AdmissionApplication::with([

                'course',

            ])

            ->latest('created_at')

            ->take(8)

            ->get();

        /*

        |--------------------------------------------------------------------------

        | PROGRAMME STRUCTURE

        |--------------------------------------------------------------------------

        |

        | Program Group

        |   Department

        |      Sub Department

        |          Programme

        |              Year

        |                  Semester

        |

        */

        $programGroups = ProgramGroup::with([

            'departments' => function ($query) {

                $query

                    ->where('is_active', true)

                    ->orderBy('name');

            },

            'departments.subDepartments' => function ($query) {

                $query

                    ->where('is_active', true)

                    ->orderBy('name');

            },

            'departments.subDepartments.courses' => function ($query) {

                $query

                    ->where('is_active', true)

                    ->orderBy('name');

            },

            'departments.subDepartments.courses.years' => function ($query) {

                $query

                    ->where('is_active', true)

                    ->orderBy('year_number');

            },

            'departments.subDepartments.courses.years.semesters.semester',

        ])

        ->where('is_active', true)

        ->orderBy('name')

        ->get();

        /*

        |--------------------------------------------------------------------------

        | CURRENT STUDENT DISTRIBUTION

        |--------------------------------------------------------------------------

        |

        | Only ACTIVE enrolments in the current academic session

        | are counted.

        |

        */

        $studentStats = collect();

        if ($activeSessionId) {

            $studentStats = DB::table(

                'student_enrollments'

           )

            ->select(

                'course_id',

                'year_number',

                'current_semester_id',

                DB::raw('COUNT(*) as student_count')

           )

            ->where(

                'academic_session_id',

                $activeSessionId

           )

            ->where(

                'enrollment_status',

                'active'

           )

            ->groupBy(

                'course_id',

                'year_number',

                'current_semester_id'

           )

            ->get();

        }

        /*

        |--------------------------------------------------------------------------

        | CONVERT STATISTICS TO EASY LOOKUP

        |--------------------------------------------------------------------------

        */

        $courseStudentStats = [];

        foreach ($studentStats as $row) {

            $courseId =

                (int) $row->course_id;

            $yearNumber =

                (int) $row->year_number;

            $semesterId =

                $row->current_semester_id

                ? (int) $row->current_semester_id

                : null;

            $studentCount =

                (int) $row->student_count;

            if (! isset(

                $courseStudentStats[$courseId]

           )) {

                $courseStudentStats[$courseId] = [

                    'total' => 0,

                    'years' => [],

                ];

            }

            $courseStudentStats[$courseId]['total']

                += $studentCount;

            if (! isset(

                $courseStudentStats[$courseId]['years'][$yearNumber]

           )) {

                $courseStudentStats[$courseId]['years'][$yearNumber] = [

                    'total' => 0,

                    'semesters' => [],

                ];

            }

            $courseStudentStats[$courseId]['years'][$yearNumber]['total']

                += $studentCount;

            if ($semesterId !== null) {

                if (! isset(

                    $courseStudentStats[$courseId]['years'][$yearNumber]['semesters'][$semesterId]

               )) {

                    $courseStudentStats[$courseId]['years'][$yearNumber]['semesters'][$semesterId]

                        = 0;

                }

                $courseStudentStats[$courseId]['years'][$yearNumber]['semesters'][$semesterId]

                    += $studentCount;

            }

        }

        /*

        |--------------------------------------------------------------------------

        | APPLICATION STATISTICS BY COURSE

        |--------------------------------------------------------------------------

        */

        $applicationStats = collect();

        $applicationQuery = DB::table(

            'admission_applications'

       )

        ->select(

            'course_id',

            DB::raw(

                "SUM(

                    CASE

                        WHEN status IN

                        ('submitted','approved','rejected')

                        THEN 1

                        ELSE 0

                    END

               ) AS applied"

           ),

            DB::raw(

                "SUM(

                    CASE

                        WHEN status = 'submitted'

                        THEN 1

                        ELSE 0

                    END

               ) AS pending"

           ),

            DB::raw(

                "SUM(

                    CASE

                        WHEN status = 'approved'

                        THEN 1

                        ELSE 0

                    END

               ) AS approved"

           ),

            DB::raw(

                "SUM(

                    CASE

                        WHEN status = 'rejected'

                        THEN 1

                        ELSE 0

                    END

               ) AS rejected"

           ),

            DB::raw(

                "COUNT(id) AS total"

           )

       )

        ->whereNotNull('course_id');

        if ($activeSessionId) {

            $applicationQuery->where(

                'academic_session_id',

                $activeSessionId

           );

        }

        $applicationStats =

            $applicationQuery

                ->groupBy('course_id')

                ->get()

                ->keyBy('course_id');

        /*

        |--------------------------------------------------------------------------

        | ATTACH DASHBOARD DATA TO COURSES

        |--------------------------------------------------------------------------

        */

        foreach ($programGroups as $programGroup) {

            foreach (

                $programGroup->departments

                as $department

           ) {

                /*

                | Department total

                */

                $departmentStudentTotal = 0;

                foreach (

                    $department->subDepartments

                    as $subDepartment

               ) {

                    foreach (

                        $subDepartment->courses

                        as $course

                   ) {

                        /*

                        |--------------------------------------------------------------------------

                        | STUDENT COUNTS

                        |--------------------------------------------------------------------------

                        */

                        $courseStats =

                            $courseStudentStats[

                                $course->id

                            ] ?? [

                                'total' => 0,

                                'years' => [],

                            ];

                        $course->dashboard_student_total =

                            $courseStats['total'];

                        $course->dashboard_year_stats =

                            $courseStats['years'];

                        $departmentStudentTotal

                            += $courseStats['total'];

                        /*

                        |--------------------------------------------------------------------------

                        | APPLICATION COUNTS

                        |--------------------------------------------------------------------------

                        */

                        $application = $applicationStats

                            ->get($course->id);

                        $course->dashboard_applied =

                            (int) ($application->applied ?? 0);

                        $course->dashboard_pending =

                            (int) ($application->pending ?? 0);

                        $course->dashboard_approved =

                            (int) ($application->approved ?? 0);

                        $course->dashboard_rejected =

                            (int) ($application->rejected ?? 0);

                        $course->dashboard_total =

                            (int) ($application->total ?? 0);

                    }

                }

                /*

                |--------------------------------------------------------------------------

                | DEPARTMENT TOTAL

                |--------------------------------------------------------------------------

                */

                $department->dashboard_student_total =

                    $departmentStudentTotal;

                /*

                |--------------------------------------------------------------------------

                | PROGRAMME COUNT

                |--------------------------------------------------------------------------

                */

                $department->dashboard_programme_count =

                    $department->subDepartments->sum(

                        function ($subDepartment) {

                            return $subDepartment

                                ->courses

                                ->count();

                        }

                   );

            }

        }

        /*
        | REAL DASHBOARD CHART DATA
        |----------------------------------------------------------------------
        | Admissions trend uses actual created_at dates. Course strength uses
        | the active-session enrolment counts already attached to each course.
        */

        $trendStart = now()->subDays(13)->startOfDay();

        $dailyApplicationCounts = DB::table('admission_applications')
            ->selectRaw('DATE(created_at) as application_date, COUNT(*) as total')
            ->where('created_at', '>=', $trendStart)
            ->where('created_at', '<=', now())
            ->groupByRaw('DATE(created_at)')
            ->orderBy('application_date')
            ->pluck('total', 'application_date');

        $admissionsTrendLabels = collect(range(13, 0))
            ->map(fn ($daysAgo) => now()->subDays($daysAgo)->format('d M'))
            ->values()
            ->all();

        $admissionsTrendData = collect(range(13, 0))
            ->map(function ($daysAgo) use ($dailyApplicationCounts) {
                $dateKey = now()->subDays($daysAgo)->toDateString();
                return (int) ($dailyApplicationCounts[$dateKey] ?? 0);
            })
            ->values()
            ->all();

        $courseChartLabels = [];
        $courseChartData = [];

        foreach ($programGroups as $programGroup) {
            foreach ($programGroup->departments as $department) {
                foreach ($department->subDepartments as $subDepartment) {
                    foreach ($subDepartment->courses as $course) {
                        $courseChartLabels[] = $course->name;
                        $courseChartData[] = (int) ($course->dashboard_student_total ?? 0);
                    }
                }
            }
        }

        if (count($courseChartLabels) > 10) {
            $coursePairs = [];
            foreach ($courseChartLabels as $i => $label) {
                $coursePairs[] = [
                    'label' => $label,
                    'total' => $courseChartData[$i] ?? 0,
                ];
            }
            usort($coursePairs, fn ($a, $b) => $b['total'] <=> $a['total']);
            $coursePairs = array_slice($coursePairs, 0, 10);
            $courseChartLabels = array_column($coursePairs, 'label');
            $courseChartData = array_column($coursePairs, 'total');
        }

/*
        |--------------------------------------------------------------------------
        | STATUS PERCENTAGES
        |--------------------------------------------------------------------------
        */

        $percentageBase =

            max(

                $totalApplications,

                1

           );

        $pendingPercent = round(

            (

                $submittedApplications

                / $percentageBase

           ) * 100,

            1

       );

        $approvedPercent = round(

            (

                $approvedApplications

                / $percentageBase

           ) * 100,

            1

       );

        $rejectedPercent = round(

            (

                $rejectedApplications

                / $percentageBase

           ) * 100,

            1

       );

        /*

        |--------------------------------------------------------------------------

        | DASHBOARD VIEW

        |--------------------------------------------------------------------------

        */

        return view(

            'admin.dashboard',

            compact(

                'totalStudents',

                'totalStaff',

                'totalCourses',

                'totalApplications',

                'todayApplications',

                'submittedApplications',

                'approvedApplications',

                'rejectedApplications',

                'recentApplications',

                'programGroups',

                'activeSessionName',

                'pendingPercent',

                'approvedPercent',

                'rejectedPercent',
                'admissionsTrendLabels',
                'admissionsTrendData',
                'courseChartLabels',
                'courseChartData'

           )

       );

    }

}