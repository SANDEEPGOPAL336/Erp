<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Staff Dashboard
    </title>


    <style>

        * {
            box-sizing: border-box;
        }


        :root {
            --primary: #6f42c1;
            --primary-dark: #4d2d8a;
            --sidebar: #2f2354;
            --sidebar-hover: #43326f;

            --background: #f5f6fa;
            --card: #ffffff;

            --text: #202637;
            --muted: #777f8d;
            --border: #e8eaf0;

            --green: #0d9d6d;
            --orange: #df9419;
            --red: #d94c60;
            --blue: #3476db;

            --shadow:
                0 8px 24px rgba(31, 41, 55, .07);
        }


        html {
            -webkit-text-size-adjust: 100%;
            text-rendering: optimizeLegibility;
        }

        body {
            margin: 0;

            font-family:
                "Segoe UI",
                Inter,
                Roboto,
                Arial,
                Helvetica,
                sans-serif;

            font-size: 14px;
            font-weight: 500;
            line-height: 1.5;

            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;

            background:
                var(--background);

            color:
                var(--text);
        }


        /* =====================================================
           TOP BAR
        ===================================================== */

        .topbar {

            height: 72px;

            background:
                linear-gradient(
                    135deg,
                    #7450c7,
                    #5f39ad
                );

            color: white;

            display: flex;

            align-items: center;

            justify-content: space-between;

            padding:
                0 22px;

            position: sticky;

            top: 0;

            z-index: 100;

            box-shadow:
                0 5px 18px rgba(45, 30, 81, .18);
        }


        .topbar-title {

            display: flex;

            align-items: center;

            gap: 10px;

            font-size: 22px;

            line-height: 1.2;
            font-weight: 800;
        }


        .topbar-title-icon {

            width: 34px;
            height: 34px;

            display: flex;

            align-items: center;

            justify-content: center;

            background:
                rgba(255,255,255,.13);

            border:
                1px solid
                rgba(255,255,255,.16);

            border-radius: 10px;

            font-size: 16px;
        }


        .user-area {

            display: flex;

            align-items: center;

            gap: 12px;

            font-size: 14px;

            font-weight: 700;
        }


        .user-name {

            opacity: .96;
        }


        .staff-logout {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            padding:
                8px 12px;

            border: 0;

            border-radius: 9px;

            background:
                rgba(255,255,255,.14);

            color: white;

            cursor: pointer;

            font-size: 11px;

            font-weight: 700;

            transition:
                background .2s ease;
        }


        .staff-logout:hover {

            background:
                rgba(255,255,255,.22);
        }


        /* =====================================================
           MAIN LAYOUT
        ===================================================== */

        .layout {

            display: flex;

            min-height:
                calc(100vh - 72px);
        }


        /* =====================================================
           SIDEBAR
        ===================================================== */

        .sidebar {

            width: 270px;

            flex: 0 0 270px;

            background:
                linear-gradient(
                    180deg,
                    #302354 0%,
                    #282044 100%
                );

            color: white;

            padding:
                17px 10px;

            box-shadow:
                5px 0 18px rgba(35, 24, 63, .08);
        }


        .sidebar-heading {

            padding:
                5px 12px 14px;

            color:
                rgba(255,255,255,.64);

            font-size: 11px;

            font-weight: 700;

            text-transform:
                uppercase;

            letter-spacing:
                .7px;
        }


        .sidebar-profile {

            display: flex;

            align-items: center;

            gap: 10px;

            margin:
                0 5px 15px;

            padding:
                11px;

            border-radius: 13px;

            background:
                rgba(255,255,255,.07);

            border:
                1px solid
                rgba(255,255,255,.08);
        }


        .sidebar-avatar {

            width: 38px;
            height: 38px;

            flex: 0 0 38px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 10px;

            background:
                linear-gradient(
                    135deg,
                    #8c6be8,
                    #5a40c0
                );

            font-size: 11px;

            font-weight: 900;
        }


        .sidebar-profile-name {

            min-width: 0;

            font-size: 14px;

            font-weight: 800;

            white-space: nowrap;

            overflow: hidden;

            text-overflow: ellipsis;
        }


        .sidebar-profile-code {

            margin-top: 3px;

            color:
                rgba(255,255,255,.56);

            font-size: 10px;

            white-space: nowrap;

            overflow: hidden;

            text-overflow: ellipsis;
        }


        .sidebar a,
        .sidebar-item-disabled {

            display: flex;

            align-items: center;

            gap: 10px;

            width: 100%;

            min-height: 40px;

            padding:
                9px 11px;

            margin:
                2px 0;

            border-radius: 10px;

            text-decoration: none;

            color:
                rgba(255,255,255,.83);

            font-size: 13px;

            font-weight: 600;

            transition:
                background .18s ease,
                color .18s ease,
                transform .18s ease;
        }


        .sidebar a:hover {

            background:
                rgba(255,255,255,.09);

            color: #ffffff;

            transform:
                translateX(2px);
        }


        .sidebar a.active {

            background:
                linear-gradient(
                    135deg,
                    #7857dc,
                    #6041bd
                );

            color: #ffffff;

            box-shadow:
                0 7px 16px rgba(86, 58, 176, .24);
        }


        .sidebar-icon {

            width: 25px;
            height: 25px;

            flex: 0 0 25px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 8px;

            background:
                rgba(255,255,255,.07);

            font-size: 16px;
        }


        .sidebar a.active .sidebar-icon {

            background:
                rgba(255,255,255,.15);
        }


        .sidebar-label {

            flex: 1;
        }


        .coming-soon {

            flex: 0 0 auto;

            padding:
                3px 5px;

            border-radius: 5px;

            background:
                rgba(255,255,255,.07);

            color:
                rgba(255,255,255,.42);

            font-size: 9px;

            text-transform:
                uppercase;

            letter-spacing:
                .35px;

            font-weight: 900;
        }


        /* =====================================================
           CONTENT
        ===================================================== */

        .content {

            flex: 1;

            min-width: 0;

            padding:
                28px;

            background:
                radial-gradient(
                    circle at top right,
                    rgba(111,66,193,.05),
                    transparent 25%
                ),
                var(--background);
        }


        /* =====================================================
           WELCOME
        ===================================================== */

        .welcome {

            position: relative;

            overflow: hidden;

            background:
                radial-gradient(
                    circle at 100% 0%,
                    rgba(111,66,193,.08),
                    transparent 30%
                ),
                #ffffff;

            border:
                1px solid
                var(--border);

            border-radius: 16px;

            padding:
                22px 24px;

            margin-bottom: 18px;

            box-shadow:
                var(--shadow);
        }


        .welcome h1 {

            margin: 0 0 7px;

            color:
                #4b2e83;

            font-size: 28px;

            line-height: 1.2;

            font-weight: 800;
        }


        .welcome p {

            margin: 0;

            color:
                #747d8c;

            font-size: 14px;

            line-height: 1.7;
        }


        .welcome strong {

            color:
                #303849;
        }


        /* =====================================================
           STAT CARDS
        ===================================================== */

        .cards {

            display: grid;

            grid-template-columns:
                repeat(4, minmax(0, 1fr));

            gap: 14px;

            margin-bottom: 20px;
        }


        .card {

            position: relative;

            overflow: hidden;

            background:
                #ffffff;

            border:
                1px solid
                var(--border);

            border-radius: 15px;

            padding:
                17px;

            box-shadow:
                var(--shadow);

            transition:
                transform .2s ease,
                box-shadow .2s ease;
        }


        .card:hover {

            transform:
                translateY(-3px);

            box-shadow:
                0 14px 30px rgba(31,41,55,.10);
        }


        .card::after {

            content: "";

            position: absolute;

            width: 80px;
            height: 80px;

            right: -35px;
            top: -35px;

            border-radius: 50%;

            background:
                rgba(111,66,193,.07);
        }


        .card-title {

            color:
                #7c8492;

            font-size: 12px;

            font-weight: 700;

            text-transform:
                uppercase;

            letter-spacing:
                .35px;
        }


        .card-number {

            margin-top: 9px;

            color:
                #4b2e83;

            font-size: 34px;

            line-height: 1;

            font-weight: 800;
        }


        /* =====================================================
           MODULE SECTION
        ===================================================== */

        .section-header {

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 15px;

            margin-bottom: 11px;
        }


        .section-header h2 {

            margin: 0;

            font-size: 20px;

            color:
                #2e3545;

            font-weight: 850;
        }


        .section-header p {

            margin: 3px 0 0;

            color:
                #8b93a1;

            font-size: 12px;
        }


        .permission-state {

            padding:
                7px 10px;

            border-radius: 9px;

            background:
                #f5f2ff;

            border:
                1px solid
                #e6e0ff;

            color:
                #5c44cf;

            font-size: 11px;

            font-weight: 850;
        }


        .modules {

            display: grid;

            grid-template-columns:
                repeat(3, minmax(0, 1fr));

            gap: 13px;
        }


        .module {

            position: relative;

            background:
                #ffffff;

            border:
                1px solid
                var(--border);

            border-radius: 15px;

            padding:
                17px;

            box-shadow:
                var(--shadow);

            min-height: 188px;

            display: flex;

            flex-direction: column;

            justify-content: space-between;
        }


        .module-top {

            display: flex;

            align-items: flex-start;

            justify-content: space-between;

            gap: 12px;
        }


        .module-icon {

            width: 39px;
            height: 39px;

            border-radius: 11px;

            display: flex;

            align-items: center;

            justify-content: center;

            background:
                #f3efff;

            color:
                #6041c6;

            font-size: 19px;
        }


        .module h3 {

            margin:
                10px 0 0;

            color:
                #303747;

            font-size: 16px;

            font-weight: 700;
        }


        .module p {

            margin:
                6px 0 15px;

            color:
                #777f8d;

            font-size: 13px;

            line-height: 1.65;
        }


        .module-btn {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            width: fit-content;

            min-height: 33px;

            padding:
                8px 11px;

            border-radius: 9px;

            background:
                linear-gradient(
                    135deg,
                    #7451d2,
                    #5737ba
                );

            color:
                white;

            text-decoration: none;

            font-size: 11px;

            font-weight: 800;

            letter-spacing:
                .3px;
        }


        .module-btn:hover {

            filter:
                brightness(.97);
        }


        .module .coming-soon-module {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            width: fit-content;

            min-height: 29px;

            padding:
                7px 9px;

            border-radius: 8px;

            background:
                #f5f6f8;

            border:
                1px solid
                #e6e8ed;

            color:
                #858d99;

            font-size: 10px;

            font-weight: 800;

            text-transform:
                uppercase;
        }


        /* =====================================================
           PERMISSION NOTICE
        ===================================================== */

        .no-permission {

            margin-top: 16px;

            padding:
                13px 15px;

            border-radius:
                12px;

            border:
                1px dashed
                #dcdfe6;

            background:
                #fbfcfd;

            color:
                #8c94a2;

            font-size: 12px;

            text-align: center;
        }


        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media (max-width: 1100px) {

            .cards {

                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }

            .modules {

                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }

        }


        @media (max-width: 800px) {

            .sidebar {

                width: 210px;

                flex-basis: 210px;
            }

            .content {

                padding:
                    18px;
            }

        }


        @media (max-width: 680px) {

            .topbar {

                height: auto;

                min-height: 72px;

                padding:
                    11px 14px;

                gap: 10px;

                flex-wrap: wrap;
            }

            .topbar-title {

                font-size: 15px;
            }

            .user-area {

                font-size: 10px;
            }

            .layout {

                flex-direction:
                    column;
            }

            .sidebar {

                width: 100%;

                flex-basis: auto;

                padding:
                    10px;
            }

            .sidebar-profile {

                max-width: 360px;
            }

            .cards,
            .modules {

                grid-template-columns:
                    1fr;
            }

        }

    </style>

</head>


<body>


    {{-- =====================================================
         TOP BAR
    ====================================================== --}}

    <div class="topbar">


        <div class="topbar-title">

            <div class="topbar-title-icon">
                🎓
            </div>

            College ERP
            —
            Unit Teacher Panel 

        </div>


        <div class="user-area">


            <span class="user-name">
                {{ auth()->user()->name }}
            </span>


            <form
                action="{{ route('staff.logout') }}"
                method="POST"
                style="margin:0;"
            >

                @csrf

                <button
                    type="submit"
                    class="staff-logout"
                >
                    Logout
                </button>

            </form>


        </div>

    </div>



    <div class="layout">


        {{-- =================================================
             SIDEBAR
        ================================================== --}}

        <aside class="sidebar">


            <div class="sidebar-heading">
                Staff Menu
            </div>


            @php

                $staffName =
                    auth()->user()->name
                    ??
                    'Staff Member';

                $initials =
                    strtoupper(
                        collect(
                            preg_split(
                                '/\s+/',
                                trim($staffName)
                            )
                        )
                        ->filter()
                        ->take(2)
                        ->map(
                            fn($word) =>
                                substr($word, 0, 1)
                        )
                        ->implode('')
                    );


                /*
                |--------------------------------------------------------------------------
                | Load all active permissions once.
                |--------------------------------------------------------------------------
                */

                $today =
                    now()->toDateString();


                $activePermissionKeys =
                    $staffProfile
                        ->permissions()
                        ->where(
                            'is_active',
                            true
                        )
                        ->where(
                            function ($query) use ($today) {

                                $query
                                    ->whereNull(
                                        'start_date'
                                    )
                                    ->orWhereDate(
                                        'start_date',
                                        '<=',
                                        $today
                                    );

                            }
                        )
                        ->where(
                            function ($query) use ($today) {

                                $query
                                    ->whereNull(
                                        'end_date'
                                    )
                                    ->orWhereDate(
                                        'end_date',
                                        '>=',
                                        $today
                                    );

                            }
                        )
                        ->pluck(
                            'permission_key'
                        )
                        ->flip();

            @endphp



            {{-- =================================================
                 STAFF PROFILE
            ================================================== --}}

            <div class="sidebar-profile">


                <div class="sidebar-avatar">

                    {{ $initials ?: 'ST' }}

                </div>


                <div>

                    <div class="sidebar-profile-name">

                        {{ $staffName }}

                    </div>


                    <div class="sidebar-profile-code">

                        {{ $staffProfile->employee_code }}

                    </div>

                </div>


            </div>



            {{-- =================================================
                 DASHBOARD
            ================================================== --}}

            <a
                href="{{ route('staff.dashboard') }}"
                class="
                    {{ request()->routeIs('staff.dashboard')
                        ? 'active'
                        : ''
                    }}
                "
            >

                <span class="sidebar-icon">
                    🏠
                </span>

                <span class="sidebar-label">
                    Dashboard
                </span>

            </a>



            {{-- =================================================
                 NEW APPLICANTS
            ================================================== --}}

            @if(isset($activePermissionKeys['new_applicants']))

                <a
                    href="{{ route('staff.applications.index') }}"
                    class="
                        {{
                            request()->routeIs(
                                'staff.applications.*'
                            )
                            ? 'active'
                            : ''
                        }}
                    "
                >

                    <span class="sidebar-icon">
                        📝
                    </span>

                    <span class="sidebar-label">
                        New Applicants
                    </span>

                </a>

            @endif



            {{-- =================================================
                 REGISTERED APPLICANTS
            ================================================== --}}

            @if(isset($activePermissionKeys['registered_applicants']))

                <a
                    href="#"
                    onclick="return false;"
                    title="Registered Applicants module will be connected next."
                >

                    <span class="sidebar-icon">
                        🎓
                    </span>

                    <span class="sidebar-label">
                        Registered Applicants
                    </span>

                    <span class="coming-soon">
                        Soon
                    </span>

                </a>

            @endif



            {{-- =================================================
                 MANAGE ATTENDANCE
            ================================================== --}}

            @if(isset($activePermissionKeys['manage_attendance']))

                <a
                    href="#"
                    onclick="return false;"
                    title="Attendance module will be connected next."
                >

                    <span class="sidebar-icon">
                        📊
                    </span>

                    <span class="sidebar-label">
                        Manage Attendance
                    </span>

                    <span class="coming-soon">
                        Soon
                    </span>

                </a>

            @endif



            {{-- =================================================
                 PREVIOUS ATTENDANCE
            ================================================== --}}

            @if(isset($activePermissionKeys['previous_attendance']))

                <a
                    href="#"
                    onclick="return false;"
                    title="Previous Attendance module will be connected next."
                >

                    <span class="sidebar-icon">
                        📁
                    </span>

                    <span class="sidebar-label">
                        Previous Attendance Files
                    </span>

                    <span class="coming-soon">
                        Soon
                    </span>

                </a>

            @endif



            {{-- =================================================
                 READMISSION
            ================================================== --}}

            @if(isset($activePermissionKeys['readmission']))

                <a
                    href="#"
                    onclick="return false;"
                    title="Readmission module will be connected next."
                >

                    <span class="sidebar-icon">
                        🔄
                    </span>

                    <span class="sidebar-label">
                        Readmission
                    </span>

                    <span class="coming-soon">
                        Soon
                    </span>

                </a>

            @endif



            {{-- =================================================
                 HOUSE EXAMS
            ================================================== --}}

            @if(isset($activePermissionKeys['house_exams']))

                <a
                    href="#"
                    onclick="return false;"
                    title="House Exams module will be connected next."
                >

                    <span class="sidebar-icon">
                        📋
                    </span>

                    <span class="sidebar-label">
                        House Exams
                    </span>

                    <span class="coming-soon">
                        Soon
                    </span>

                </a>

            @endif



            {{-- =================================================
                 MARKSHEET
            ================================================== --}}

            @if(isset($activePermissionKeys['marksheet_management']))

                <a
                    href="#"
                    onclick="return false;"
                    title="Marksheet Management module will be connected next."
                >

                    <span class="sidebar-icon">
                        📑
                    </span>

                    <span class="sidebar-label">
                        Marksheet Management
                    </span>

                    <span class="coming-soon">
                        Soon
                    </span>

                </a>

            @endif



            {{-- =================================================
                 FEE CONCESSION
            ================================================== --}}

            @if(isset($activePermissionKeys['fee_concession']))

                <a
                    href="#"
                    onclick="return false;"
                    title="Fee Concession module will be connected next."
                >

                    <span class="sidebar-icon">
                        💳
                    </span>

                    <span class="sidebar-label">
                        Fee Concession
                    </span>

                    <span class="coming-soon">
                        Soon
                    </span>

                </a>

            @endif



            {{-- =================================================
                 ONLINE FEE
            ================================================== --}}

            @if(isset($activePermissionKeys['online_fee_verification']))

                <a
                    href="#"
                    onclick="return false;"
                    title="Online Fee Verification module will be connected next."
                >

                    <span class="sidebar-icon">
                        💻
                    </span>

                    <span class="sidebar-label">
                        Online Fee Verification
                    </span>

                    <span class="coming-soon">
                        Soon
                    </span>

                </a>

            @endif



            {{-- =================================================
                 OFFLINE FEE
            ================================================== --}}

            @if(isset($activePermissionKeys['offline_fee_verification']))

                <a
                    href="#"
                    onclick="return false;"
                    title="Offline Fee Verification module will be connected next."
                >

                    <span class="sidebar-icon">
                        🧾
                    </span>

                    <span class="sidebar-label">
                        Offline Fee Verification
                    </span>

                    <span class="coming-soon">
                        Soon
                    </span>

                </a>

            @endif



            {{-- =================================================
                 COURSE CHANGE
            ================================================== --}}

            @if(isset($activePermissionKeys['course_program_change']))

                <a
                    href="#"
                    onclick="return false;"
                    title="Course / Program Change module will be connected next."
                >

                    <span class="sidebar-icon">
                        🔁
                    </span>

                    <span class="sidebar-label">
                        Course / Program Change
                    </span>

                    <span class="coming-soon">
                        Soon
                    </span>

                </a>

            @endif



            {{-- =================================================
                 UNIVERSITY DATA
            ================================================== --}}

            @if(isset($activePermissionKeys['university_data']))

                <a
                    href="#"
                    onclick="return false;"
                    title="University Data module will be connected next."
                >

                    <span class="sidebar-icon">
                        🏛️
                    </span>

                    <span class="sidebar-label">
                        University Data
                    </span>

                    <span class="coming-soon">
                        Soon
                    </span>

                </a>

            @endif


        </aside>



        {{-- =================================================
             MAIN CONTENT
        ================================================== --}}

        <main class="content">


            {{-- =================================================
                 WELCOME
            ================================================== --}}

            <section class="welcome">


                <h1>
                    Welcome,
                    {{ auth()->user()->name }}
                </h1>


                <p>

                    Employee Code:
                    <strong>
                        {{ $staffProfile->employee_code }}
                    </strong>

                    &nbsp; | &nbsp;

                    Designation:
                    <strong>
                        {{ $staffProfile->designation ?? '-' }}
                    </strong>

                </p>


            </section>



            {{-- =================================================
                 STATISTICS
            ================================================== --}}

            <section class="cards">


                <div class="card">

                    <div class="card-title">
                        New Applicants
                    </div>

                    <div class="card-number">
                        {{ $newApplicants }}
                    </div>

                </div>


                <div class="card">

                    <div class="card-title">
                        Approved Applications
                    </div>

                    <div class="card-number">
                        {{ $approvedApplications }}
                    </div>

                </div>


                <div class="card">

                    <div class="card-title">
                        Rejected Applications
                    </div>

                    <div class="card-number">
                        {{ $rejectedApplications }}
                    </div>

                </div>


                <div class="card">

                    <div class="card-title">
                        Draft Applications
                    </div>

                    <div class="card-number">
                        {{ $draftApplications }}
                    </div>

                </div>


            </section>



            {{-- =================================================
                 AVAILABLE MODULES
            ================================================== --}}

            <div class="section-header">


                <div>

                    <h2>
                        My Assigned Modules
                    </h2>

                    <p>
                        Modules shown below are based on permissions assigned by the administrator.
                    </p>

                </div>


                <div class="permission-state">

                    🔐

                    {{ $activePermissionKeys->count() }}

                    Active Permissions

                </div>


            </div>



            <section class="modules">


                {{-- NEW APPLICANTS MODULE --}}

                @if(isset($activePermissionKeys['new_applicants']))

                    <div class="module">


                        <div>

                            <div class="module-top">

                                <div class="module-icon">
                                    📝
                                </div>

                            </div>


                            <h3>
                                New Applicants
                            </h3>


                            <p>

                                View and verify admission applications
                                submitted by students assigned to you.

                            </p>

                        </div>


                        <a
                            href="{{ route('staff.applications.index') }}"
                            class="module-btn"
                        >
                            VIEW APPLICANTS
                        </a>


                    </div>

                @endif



                {{-- REGISTERED APPLICANTS --}}

                @if(isset($activePermissionKeys['registered_applicants']))

                    <div class="module">


                        <div>

                            <div class="module-top">

                                <div class="module-icon">
                                    🎓
                                </div>

                            </div>


                            <h3>
                                Registered Applicants
                            </h3>


                            <p>

                                View students whose admission and
                                registration process has been completed.

                            </p>

                        </div>


                        <span class="coming-soon-module">
                            Module Coming Soon
                        </span>


                    </div>

                @endif



                {{-- ATTENDANCE --}}

                @if(isset($activePermissionKeys['manage_attendance']))

                    <div class="module">


                        <div>

                            <div class="module-top">

                                <div class="module-icon">
                                    📊
                                </div>

                            </div>


                            <h3>
                                Manage Attendance
                            </h3>


                            <p>

                                Manage attendance for assigned
                                courses, years and semesters.

                            </p>

                        </div>


                        <span class="coming-soon-module">
                            Module Coming Soon
                        </span>


                    </div>

                @endif



                {{-- PREVIOUS ATTENDANCE --}}

                @if(isset($activePermissionKeys['previous_attendance']))

                    <div class="module">


                        <div>

                            <div class="module-top">

                                <div class="module-icon">
                                    📁
                                </div>

                            </div>


                            <h3>
                                Previous Attendance Files
                            </h3>


                            <p>

                                Access previously uploaded attendance
                                records and files.

                            </p>

                        </div>


                        <span class="coming-soon-module">
                            Module Coming Soon
                        </span>


                    </div>

                @endif



                {{-- READMISSION --}}

                @if(isset($activePermissionKeys['readmission']))

                    <div class="module">


                        <div>

                            <div class="module-top">

                                <div class="module-icon">
                                    🔄
                                </div>

                            </div>


                            <h3>
                                Readmission
                            </h3>


                            <p>

                                Process readmission applications
                                for eligible students.

                            </p>

                        </div>


                        <span class="coming-soon-module">
                            Module Coming Soon
                        </span>


                    </div>

                @endif



                {{-- HOUSE EXAMS --}}

                @if(isset($activePermissionKeys['house_exams']))

                    <div class="module">


                        <div>

                            <div class="module-top">

                                <div class="module-icon">
                                    📋
                                </div>

                            </div>


                            <h3>
                                House Exams
                            </h3>


                            <p>

                                Manage internal and house examination
                                activities.

                            </p>

                        </div>


                        <span class="coming-soon-module">
                            Module Coming Soon
                        </span>


                    </div>

                @endif



                {{-- MARKSHEET --}}

                @if(isset($activePermissionKeys['marksheet_management']))

                    <div class="module">


                        <div>

                            <div class="module-top">

                                <div class="module-icon">
                                    📑
                                </div>

                            </div>


                            <h3>
                                Marksheet Management
                            </h3>


                            <p>

                                Manage student marks and examination
                                marksheets.

                            </p>

                        </div>


                        <span class="coming-soon-module">
                            Module Coming Soon
                        </span>


                    </div>

                @endif



                {{-- FEE CONCESSION --}}

                @if(isset($activePermissionKeys['fee_concession']))

                    <div class="module">


                        <div>

                            <div class="module-top">

                                <div class="module-icon">
                                    💳
                                </div>

                            </div>


                            <h3>
                                Fee Concession
                            </h3>


                            <p>

                                Process eligible fee concession
                                requests and approvals.

                            </p>

                        </div>


                        <span class="coming-soon-module">
                            Module Coming Soon
                        </span>


                    </div>

                @endif



                {{-- ONLINE FEE --}}

                @if(isset($activePermissionKeys['online_fee_verification']))

                    <div class="module">


                        <div>

                            <div class="module-top">

                                <div class="module-icon">
                                    💻
                                </div>

                            </div>


                            <h3>
                                Online Fee Verification
                            </h3>


                            <p>

                                Verify online student fee payment
                                transactions.

                            </p>

                        </div>


                        <span class="coming-soon-module">
                            Module Coming Soon
                        </span>


                    </div>

                @endif



                {{-- OFFLINE FEE --}}

                @if(isset($activePermissionKeys['offline_fee_verification']))

                    <div class="module">


                        <div>

                            <div class="module-top">

                                <div class="module-icon">
                                    🧾
                                </div>

                            </div>


                            <h3>
                                Offline Fee Verification
                            </h3>


                            <p>

                                Verify offline and manual fee
                                payment records.

                            </p>

                        </div>


                        <span class="coming-soon-module">
                            Module Coming Soon
                        </span>


                    </div>

                @endif



                {{-- COURSE CHANGE --}}

                @if(isset($activePermissionKeys['course_program_change']))

                    <div class="module">


                        <div>

                            <div class="module-top">

                                <div class="module-icon">
                                    🔁
                                </div>

                            </div>


                            <h3>
                                Course / Program Change
                            </h3>


                            <p>

                                Process approved requests for
                                course or programme changes.

                            </p>

                        </div>


                        <span class="coming-soon-module">
                            Module Coming Soon
                        </span>


                    </div>

                @endif



                {{-- UNIVERSITY DATA --}}

                @if(isset($activePermissionKeys['university_data']))

                    <div class="module">


                        <div>

                            <div class="module-top">

                                <div class="module-icon">
                                    🏛️
                                </div>

                            </div>


                            <h3>
                                University Data
                            </h3>


                            <p>

                                Manage university-related student
                                data and submissions.

                            </p>

                        </div>


                        <span class="coming-soon-module">
                            Module Coming Soon
                        </span>


                    </div>

                @endif


            </section>



            {{-- =================================================
                 NO PERMISSION MESSAGE
            ================================================== --}}

            @if($activePermissionKeys->count() === 0)

                <div class="no-permission">

                    No staff modules have been assigned to your account yet.
                    Please contact the administrator.

                </div>

            @endif


        </main>


    </div>


</body>

</html>
