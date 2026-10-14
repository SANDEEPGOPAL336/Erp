<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>
        Choose Course - College ERP
    </title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f5f9;
            color: #222;
        }

        .topbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;

            height: 62px;

            background: #40358f;
            color: white;

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 0 22px;

            z-index: 1000;
        }

        .sidebar {
            position: fixed;

            top: 62px;
            left: 0;
            bottom: 0;

            width: 230px;

            background: #cecece;

            overflow-y: auto;

            z-index: 900;
        }

        .logo-area {
            text-align: center;
            padding: 20px 10px;
            border-bottom: 1px solid #aaa;
        }

        .logo-circle {
            width: 82px;
            height: 82px;

            border-radius: 50%;

            background: white;

            display: flex;
            justify-content: center;
            align-items: center;

            margin: 0 auto 10px;

            color: #40358f;
            font-weight: bold;
        }

        .menu-link {
            display: block;

            width: 100%;

            padding: 12px 14px;

            text-decoration: none;

            color: #222;

            font-size: 13px;

            border: 0;

            background: transparent;

            text-align: left;

            cursor: pointer;
        }

        .menu-link:hover {
            background: white;
        }

        .menu-link.active {
            background: white;
            color: #40358f;
            font-weight: bold;

            border-left: 4px solid #40358f;

            padding-left: 10px;
        }

        .main-content {
            margin-left: 230px;

            padding: 88px 30px 40px;

            min-height: 100vh;
        }

        .page-title {
            font-size: 23px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .card {
            background: white;

            border-radius: 8px;

            padding: 25px;

            max-width: 900px;

            box-shadow:
                0 2px 8px rgba(0,0,0,0.08);
        }

        .section-title {
            background: #40358f;
            color: white;

            padding: 12px 15px;

            margin: -25px -25px 25px;

            border-radius: 8px 8px 0 0;

            font-size: 16px;

            font-weight: bold;
        }

        .form-row {
            display: grid;

            grid-template-columns:
                repeat(2, 1fr);

            gap: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;

            margin-bottom: 7px;

            font-size: 13px;

            font-weight: bold;
        }

        select {
            width: 100%;

            padding: 11px;

            border: 1px solid #ccc;

            border-radius: 5px;

            background: white;

            font-size: 14px;
        }

        select:focus {
            outline: none;
            border-color: #40358f;
            box-shadow: 0 0 0 2px rgba(64,53,143,0.10);
        }

        .department-note {
            margin-top: 8px;
            font-size: 12px;
            color: #666;
        }

        .course-info {
            margin-top: 15px;

            background: #f7f7fb;

            border: 1px solid #e2e2e7;

            padding: 14px;

            border-radius: 6px;

            font-size: 13px;
        }

        .course-info strong {
            color: #40358f;
        }

        .no-course-message {
            display: none;

            margin-top: 8px;

            padding: 9px 11px;

            border-radius: 5px;

            background: #fff3cd;

            color: #664d03;

            font-size: 12px;

            border: 1px solid #ffecb5;
        }

        .button-row {
            margin-top: 25px;

            display: flex;

            justify-content: flex-end;

            gap: 10px;
        }

        .btn {
            border: 0;

            border-radius: 5px;

            padding: 11px 22px;

            cursor: pointer;

            font-size: 13px;

            text-decoration: none;

            display: inline-block;
        }

        .btn-success {
            background: #198754;
            color: white;
        }

        .btn-success:hover {
            background: #157347;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5c636a;
        }

        .alert-error {
            background: #f8d7da;

            color: #842029;

            border: 1px solid #f5c2c7;

            border-radius: 6px;

            padding: 12px;

            margin-bottom: 20px;
        }

        .alert-success {
            background: #d1e7dd;

            color: #0f5132;

            border: 1px solid #badbcc;

            border-radius: 6px;

            padding: 12px;

            margin-bottom: 20px;
        }

        @media (max-width: 800px) {

            .sidebar {
                width: 180px;
            }

            .main-content {
                margin-left: 180px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

        }

    </style>

</head>

<body>


<header class="topbar">

    <strong>
        Student Panel
    </strong>

    <span>
        {{ auth()->user()->name }}
    </span>

</header>


<aside class="sidebar">


    <div class="logo-area">

        <div class="logo-circle">
            COLLEGE
        </div>

        <small>
            Student Portal
        </small>

    </div>


    <a
        href="{{ route('student.dashboard') }}"
        class="menu-link"
    >
        🏠 Dashboard
    </a>


    <a
        href="{{ route('student.admission.course') }}"
        class="menu-link active"
    >
        📚 Course / Programme
    </a>


    <a
        href="{{ route('student.personal') }}"
        class="menu-link"
    >
        👤 Personal Information
    </a>


    <a
        href="#"
        class="menu-link"
    >
        🎓 Education Qualification
    </a>


    <a
        href="#"
        class="menu-link"
    >
        📄 Document Upload
    </a>


    <a
        href="#"
        class="menu-link"
    >
        📝 Registration Form
    </a>


    <form
        method="POST"
        action="{{ route('logout') }}"
        style="margin:0;"
    >

        @csrf

        <button
            type="submit"
            class="menu-link"
        >
            🔒 Sign Out
        </button>

    </form>


</aside>


<main class="main-content">


    <div class="page-title">

        STEP 1: CHOOSE COURSE

    </div>


    @if(session('success'))

        <div class="alert-success">

            {{ session('success') }}

        </div>

    @endif


    @if($errors->any())

        <div class="alert-error">

            @foreach($errors->all() as $error)

                <div>
                    {{ $error }}
                </div>

            @endforeach

        </div>

    @endif


    <div class="card">


        <div class="section-title">

            Admission Details

        </div>


        <form
            method="POST"
            action="{{ route('student.admission.course.save') }}"
        >

            @csrf


            <div class="form-row">


                {{-- =========================================================
                     ADMISSION TYPE
                ========================================================== --}}

                <div class="form-group">

                    <label>
                        Admission Type
                    </label>

                    <select disabled>

                        <option>
                            {{ $application->admission_type }}
                        </option>

                    </select>

                    <input
                        type="hidden"
                        name="admission_type"
                        value="{{ $application->admission_type }}"
                    >

                </div>


                {{-- =========================================================
                     DEPARTMENT
                ========================================================== --}}

                <div class="form-group">

                    <label for="department">

                        Department
                        <span style="color:#dc3545;">*</span>

                    </label>

                    <select
                        name="department_id"
                        id="department"
                        required
                    >

                        <option value="">
                            Select Department
                        </option>

                        @foreach($departments as $department)

                            <option
                                value="{{ $department->id }}"
                                @selected(
                                    old(
                                        'department_id',
                                        $selectedDepartmentId
                                    ) == $department->id
                                )
                            >

                                {{ $department->name }}

                                @if(!empty($department->code))

                                    ({{ $department->code }})

                                @endif

                            </option>

                        @endforeach

                    </select>

                    <div class="department-note">

                        Department list is controlled by
                        College Administration.

                    </div>

                </div>


                {{-- =========================================================
                     COURSE / PROGRAMME
                ========================================================== --}}

                <div class="form-group">

                    <label for="course">

                        Choose Course / Programme

                        <span style="color:#dc3545;">*</span>

                    </label>

                    <select
                        name="course_id"
                        id="course"
                        required
                    >

                        <option value="">
                            Select Course / Programme
                        </option>


                        @foreach($courses as $course)

                            <option
                                value="{{ $course->id }}"
                                data-department-id="{{ $course->department_id ?? '' }}"
                                data-course-name="{{ $course->name }}"
                                data-course-code="{{ $course->code }}"
                                data-duration="{{ $course->duration }}"
                                @selected(
                                    old(
                                        'course_id',
                                        $application->course_id
                                    ) == $course->id
                                )
                            >

                                {{ $course->name }}

                                @if(!empty($course->code))

                                    ({{ $course->code }})

                                @endif

                            </option>

                        @endforeach

                    </select>


                    <div
                        id="noCourseMessage"
                        class="no-course-message"
                    >

                        No active course is currently assigned
                        to this department.

                        Please contact the College Administration.

                    </div>

                </div>


            </div>


            {{-- =========================================================
                 INFORMATION BOX
            ========================================================== --}}

            <div class="course-info">

                <strong>
                    Important:
                </strong>

                <div style="margin-top:6px;">

                    First select your Department and then select
                    the Course / Programme offered under that
                    Department.

                </div>

                <div style="margin-top:6px;">

                    Departments and courses are controlled by
                    the College Administration.

                </div>

            </div>


            {{-- =========================================================
                 BUTTONS
            ========================================================== --}}

            <div class="button-row">


                <a
                    href="{{ route('student.dashboard') }}"
                    class="btn btn-secondary"
                >

                    BACK

                </a>


                <button
                    type="submit"
                    class="btn btn-success"
                >

                    SAVE & NEXT

                </button>


            </div>


        </form>


    </div>


</main>


<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        const departmentSelect =
            document.getElementById('department');

        const courseSelect =
            document.getElementById('course');

        const noCourseMessage =
            document.getElementById('noCourseMessage');


        if (
            !departmentSelect ||
            !courseSelect
        ) {

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | Save all course options
        |--------------------------------------------------------------------------
        */

        const allCourseOptions =
            Array.from(
                courseSelect.querySelectorAll(
                    'option[data-department-id]'
                )
            );


        /*
        |--------------------------------------------------------------------------
        | Previously selected course
        |--------------------------------------------------------------------------
        */

        const currentCourseId =
            "{{ old('course_id', $application->course_id) }}";


        /*
        |--------------------------------------------------------------------------
        | Filter Courses According To Department
        |--------------------------------------------------------------------------
        */

        function filterCourses(
            restoreSelectedCourse = true
        ) {

            const departmentId =
                departmentSelect.value;


            /*
            | Reset current course
            */

            courseSelect.value = '';


            /*
            | Hide no-course message
            */

            noCourseMessage.style.display =
                'none';


            /*
            |--------------------------------------------------------------------------
            | No Department Selected
            |--------------------------------------------------------------------------
            */

            if (!departmentId) {

                allCourseOptions.forEach(
                    function (option) {

                        option.hidden = true;

                    }
                );

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | Filter Courses
            |--------------------------------------------------------------------------
            */

            let visibleCount = 0;


            allCourseOptions.forEach(
                function (option) {

                    const optionDepartmentId =
                        option.getAttribute(
                            'data-department-id'
                        );


                    if (
                        optionDepartmentId ===
                        departmentId
                    ) {

                        option.hidden = false;

                        visibleCount++;

                    }
                    else {

                        option.hidden = true;

                    }

                }
            );


            /*
            |--------------------------------------------------------------------------
            | No Course Available
            |--------------------------------------------------------------------------
            */

            if (visibleCount === 0) {

                noCourseMessage.style.display =
                    'block';

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | Restore Previously Selected Course
            |--------------------------------------------------------------------------
            */

            if (
                restoreSelectedCourse &&
                currentCourseId
            ) {

                const matchingOption =
                    allCourseOptions.find(
                        function (option) {

                            return (
                                option.value ===
                                currentCourseId
                                &&
                                option.getAttribute(
                                    'data-department-id'
                                ) === departmentId
                            );

                        }
                    );


                if (matchingOption) {

                    courseSelect.value =
                        currentCourseId;

                }

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Department Change
        |--------------------------------------------------------------------------
        */

        departmentSelect.addEventListener(
            'change',
            function () {

                /*
                | Clear previously selected course
                */

                courseSelect.value = '';


                /*
                | Filter courses
                */

                filterCourses(false);

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Initial Page Load
        |--------------------------------------------------------------------------
        */

        filterCourses(true);


        /*
        |--------------------------------------------------------------------------
        | Prevent Course Selection If No Department
        |--------------------------------------------------------------------------
        */

        courseSelect.addEventListener(
            'change',
            function () {

                const selectedOption =
                    courseSelect.options[
                        courseSelect.selectedIndex
                    ];


                if (
                    selectedOption &&
                    selectedOption.hidden
                ) {

                    courseSelect.value = '';

                }

            }
        );

    }
);

</script>


</body>

</html>