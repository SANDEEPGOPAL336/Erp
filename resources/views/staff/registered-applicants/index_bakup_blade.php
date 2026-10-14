<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Applicants — College ERP</title>

    <style>
        * { box-sizing: border-box; }

        :root {
            --primary: #6847e8;
            --primary-dark: #4f35c7;
            --primary-soft: #f2eeff;
            --sidebar: #241b4d;
            --sidebar-2: #332364;
            --text: #1e2740;
            --muted: #68738a;
            --border: #e4e8f0;
            --bg: #f4f6fb;
            --white: #ffffff;
            --success: #0f9f6e;
            --success-soft: #e8f8f2;
            --warning: #c47a00;
            --warning-soft: #fff5df;
            --danger: #d9425e;
            --danger-soft: #ffedf1;
            --shadow: 0 14px 36px rgba(31, 41, 55, .08);
        }

        html {
            -webkit-text-size-adjust: 100%;
            text-rendering: optimizeLegibility;
        }

        body {
            margin: 0;
            font-family: "Segoe UI", Inter, Roboto, Arial, Helvetica, sans-serif;
            background: var(--bg);
            color: var(--text);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .topbar {
            height: 72px;
            background: linear-gradient(100deg, #744eea 0%, #5f43d7 55%, #4f36c3 100%);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            box-shadow: 0 8px 24px rgba(79, 54, 195, .22);
            position: sticky;
            top: 0;
            z-index: 20;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 800;
            font-size: 21px;
            letter-spacing: .1px;
        }

        .brand-icon {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            display: grid;
            place-items: center;
            background: rgba(255,255,255,.16);
            border: 1px solid rgba(255,255,255,.22);
            font-size: 19px;
        }

        .top-right {
            display: flex;
            align-items: center;
            gap: 14px;
            font-size: 14px;
            font-weight: 700;
        }

        .logout-btn {
            border: 0;
            color: #fff;
            background: rgba(255,255,255,.15);
            padding: 10px 16px;
            border-radius: 11px;
            font-weight: 800;
            cursor: pointer;
        }

        .layout {
            display: flex;
            min-height: calc(100vh - 72px);
        }

        .sidebar {
            width: 250px;
            flex: 0 0 250px;
            background: linear-gradient(180deg, var(--sidebar) 0%, #2c2059 100%);
            color: #fff;
            padding: 18px 12px;
            position: sticky;
            top: 72px;
            height: calc(100vh - 72px);
            overflow-y: auto;
        }

        .sidebar-title {
            color: #cfc7ef;
            font-size: 11px;
            font-weight: 900;
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 0 10px 11px;
        }

        .staff-box {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 12px;
            border-radius: 15px;
            background: rgba(255,255,255,.07);
            border: 1px solid rgba(255,255,255,.09);
            margin-bottom: 15px;
        }

        .staff-avatar {
            width: 43px;
            height: 43px;
            border-radius: 13px;
            background: linear-gradient(135deg, #8c6ef5, #5b3fd2);
            display: grid;
            place-items: center;
            font-weight: 900;
            font-size: 14px;
        }

        .staff-name {
            font-weight: 850;
            font-size: 14px;
        }

        .staff-code {
            margin-top: 2px;
            color: #bbb1df;
            font-size: 11px;
            font-weight: 700;
        }

        .menu {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .menu a {
            color: #f6f3ff;
            text-decoration: none;
            padding: 11px 12px;
            border-radius: 11px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            font-weight: 750;
        }

        .menu a:hover,
        .menu a.active {
            background: linear-gradient(90deg, #6948db, #7751ec);
            box-shadow: 0 8px 18px rgba(71, 46, 170, .28);
        }

        .menu-icon { width: 23px; text-align: center; font-size: 16px; }

        .soon {
            margin-left: auto;
            font-size: 9px;
            padding: 3px 6px;
            border-radius: 999px;
            background: rgba(255,255,255,.1);
            color: #cfc8ef;
            font-weight: 900;
            text-transform: uppercase;
        }

        .content {
            flex: 1;
            min-width: 0;
            padding: 24px;
            background:
                radial-gradient(circle at 100% 0%, rgba(104,71,232,.08), transparent 23%),
                linear-gradient(180deg, #f8f9fc 0%, #f1f4f9 100%);
        }

        .page-head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 18px;
            margin-bottom: 20px;
        }

        .eyebrow {
            margin: 0 0 5px;
            color: var(--primary);
            font-size: 12px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: .9px;
        }

        h1 {
            margin: 0;
            font-size: 29px;
            line-height: 1.18;
            font-weight: 900;
            letter-spacing: -.55px;
        }

        .subtitle {
            margin: 8px 0 0;
            color: var(--muted);
            font-size: 14px;
            font-weight: 550;
        }

        .assignment-pill {
            background: #fff;
            border: 1px solid #dfd9fa;
            color: var(--primary-dark);
            padding: 11px 14px;
            border-radius: 13px;
            font-weight: 850;
            font-size: 12px;
            box-shadow: 0 8px 20px rgba(31,41,55,.05);
            white-space: nowrap;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(5, minmax(0,1fr));
            gap: 14px;
            margin-bottom: 18px;
        }

        .stat {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 15px 16px;
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
        }

        .stat::after {
            content: "";
            position: absolute;
            width: 70px;
            height: 70px;
            border-radius: 50%;
            right: -25px;
            top: -25px;
            background: var(--primary-soft);
        }

        .stat-label {
            position: relative;
            z-index: 1;
            color: var(--muted);
            font-size: 11px;
            font-weight: 850;
            text-transform: uppercase;
            letter-spacing: .65px;
        }

        .stat-value {
            position: relative;
            z-index: 1;
            margin-top: 5px;
            font-size: 27px;
            font-weight: 900;
            color: var(--primary-dark);
        }

        .panel {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 18px;
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .panel-head {
            padding: 18px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
        }

        .panel-title {
            font-size: 18px;
            font-weight: 900;
            margin: 0;
        }

        .panel-help {
            margin: 4px 0 0;
            font-size: 12px;
            color: var(--muted);
            font-weight: 550;
        }

        .filters {
            padding: 16px 20px;
            background: #fbfcfe;
            border-bottom: 1px solid var(--border);
            display: grid;
            grid-template-columns: 1.4fr repeat(4, 1fr) auto;
            gap: 10px;
            align-items: end;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-size: 11px;
            color: #59657a;
            font-weight: 850;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        input, select {
            width: 100%;
            min-height: 43px;
            border: 1px solid #dce1ea;
            border-radius: 11px;
            background: #fff;
            color: var(--text);
            padding: 0 12px;
            font-family: inherit;
            font-size: 13px;
            font-weight: 650;
            outline: none;
        }

        input:focus, select:focus {
            border-color: #8d79eb;
            box-shadow: 0 0 0 4px rgba(104,71,232,.1);
        }

        .filter-btn {
            min-height: 43px;
            border: 0;
            border-radius: 11px;
            padding: 0 16px;
            color: #fff;
            background: linear-gradient(135deg, #6e4be4, #5136c9);
            font-weight: 850;
            cursor: pointer;
        }

        .reset-link {
            display: inline-flex;
            min-height: 43px;
            align-items: center;
            justify-content: center;
            padding: 0 13px;
            border-radius: 11px;
            border: 1px solid #dfe3ea;
            background: #fff;
            color: #5d6679;
            text-decoration: none;
            font-size: 12px;
            font-weight: 800;
        }

        .table-wrap {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            min-width: 1050px;
            border-collapse: collapse;
        }

        th {
            background: #f7f8fc;
            color: #68738a;
            text-align: left;
            padding: 13px 14px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .55px;
            font-weight: 900;
            border-bottom: 1px solid var(--border);
        }

        td {
            padding: 14px;
            border-bottom: 1px solid #edf0f5;
            vertical-align: middle;
            font-size: 13px;
            font-weight: 650;
            color: #2e3850;
        }

        tbody tr:hover { background: #fbfaff; }

        .student-cell {
            display: flex;
            align-items: center;
            gap: 11px;
            min-width: 220px;
        }

        .photo {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            object-fit: cover;
            border: 2px solid #eeeaff;
            background: #f1efff;
            flex: 0 0 42px;
        }

        .avatar-fallback {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: linear-gradient(135deg, #dfd7ff, #9d8be9);
            color: #4d35b7;
            display: grid;
            place-items: center;
            font-weight: 900;
            flex: 0 0 42px;
        }

        .student-name {
            font-weight: 850;
            color: #1f2941;
        }

        .student-sub {
            color: #7c869a;
            font-size: 11px;
            margin-top: 2px;
        }

        .course-code {
            display: inline-block;
            min-width: 58px;
            text-align: center;
            padding: 5px 8px;
            border-radius: 8px;
            background: var(--primary-soft);
            color: var(--primary-dark);
            font-size: 10px;
            font-weight: 900;
        }

        .status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 9px;
            border-radius: 999px;
            background: var(--success-soft);
            color: var(--success);
            font-size: 10px;
            font-weight: 900;
            text-transform: uppercase;
        }

        .date { white-space: nowrap; }

        .empty {
            text-align: center;
            padding: 55px 20px;
        }

        .empty-icon {
            width: 62px;
            height: 62px;
            margin: 0 auto 12px;
            border-radius: 20px;
            display: grid;
            place-items: center;
            background: #f0ecff;
            font-size: 29px;
        }

        .empty h3 {
            margin: 0;
            font-size: 17px;
            font-weight: 900;
        }

        .empty p {
            margin: 7px 0 0;
            color: var(--muted);
            font-size: 13px;
        }

        .pagination-wrap {
            padding: 16px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            border-top: 1px solid var(--border);
        }

        .pagination-info {
            color: var(--muted);
            font-size: 12px;
            font-weight: 650;
        }

        .pagination {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        .pagination a,
        .pagination span {
            min-width: 34px;
            height: 34px;
            padding: 0 10px;
            border-radius: 9px;
            border: 1px solid #dfe3ea;
            background: #fff;
            color: #576175;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-size: 12px;
            font-weight: 850;
        }

        .pagination .active {
            background: var(--primary);
            color: #fff;
            border-color: var(--primary);
        }

        .notice {
            margin-top: 16px;
            border-radius: 14px;
            padding: 13px 15px;
            background: var(--warning-soft);
            border: 1px solid #f4ddab;
            color: #805300;
            font-size: 12px;
            font-weight: 650;
        }

        @media (max-width: 1200px) {
            .stats { grid-template-columns: repeat(3, minmax(0,1fr)); }
            .filters { grid-template-columns: repeat(3, minmax(0,1fr)); }
        }

        @media (max-width: 900px) {
            .sidebar {
                width: 220px;
                flex-basis: 220px;
            }
            .content { padding: 18px; }
            .page-head { flex-direction: column; }
        }

        @media (max-width: 700px) {
            .topbar { padding: 0 14px; }
            .brand { font-size: 17px; }
            .top-right > span { display: none; }
            .layout { display: block; }
            .sidebar {
                position: static;
                width: auto;
                height: auto;
                display: none;
            }
            .content { padding: 14px; }
            .stats { grid-template-columns: repeat(2, minmax(0,1fr)); }
            .filters { grid-template-columns: 1fr; }
            .page-head { margin-bottom: 14px; }
            h1 { font-size: 24px; }
        }
    </style>
</head>
<body>
    <header class="topbar">
        <div class="brand">
            <span class="brand-icon">🎓</span>
            College ERP — Unit Teacher Panel
        </div>

        <div class="top-right">
            <span>{{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('staff.logout') }}">
                @csrf
                <button class="logout-btn" type="submit">Logout</button>
            </form>
        </div>
    </header>

    <div class="layout">
        <aside class="sidebar">
            <div class="sidebar-title">Staff Menu</div>

            <div class="staff-box">
                @php
                    $staffName = auth()->user()->name ?? 'Staff';
                    $initials = collect(preg_split('/\s+/', trim($staffName)))
                        ->filter()
                        ->map(fn ($part) => strtoupper(substr($part, 0, 1)))
                        ->take(2)
                        ->implode('');
                @endphp

                <div class="staff-avatar">{{ $initials ?: 'ST' }}</div>
                <div>
                    <div class="staff-name">{{ $staffName }}</div>
                    <div class="staff-code">{{ $staffProfile->employee_code ?? '-' }}</div>
                </div>
            </div>

            @php
                $today = now()->toDateString();
                $activePermissionKeys = $staffProfile->permissions()
                    ->where('is_active', true)
                    ->where(function ($query) use ($today) {
                        $query->whereNull('start_date')->orWhereDate('start_date', '<=', $today);
                    })
                    ->where(function ($query) use ($today) {
                        $query->whereNull('end_date')->orWhereDate('end_date', '>=', $today);
                    })
                    ->pluck('permission_key')
                    ->flip();
            @endphp

            <nav class="menu">
                <a href="{{ route('staff.dashboard') }}" class="{{ request()->routeIs('staff.dashboard') ? 'active' : '' }}">
                    <span class="menu-icon">🏠</span>
                    <span>Dashboard</span>
                </a>

                @if(isset($activePermissionKeys['new_applicants']))
                <a href="{{ route('staff.applications.index') }}" class="{{ request()->routeIs('staff.applications.*') ? 'active' : '' }}">
                    <span class="menu-icon">📝</span>
                    <span>New Applicants</span>
                </a>
                @endif

                @if(isset($activePermissionKeys['registered_applicants']))
                <a href="{{ route('staff.registered-applicants.index') }}" class="{{ request()->routeIs('staff.registered-applicants.*') ? 'active' : '' }}">
                    <span class="menu-icon">🎓</span>
                    <span>Registered Applicants</span>
                </a>
                @endif

                @if(isset($activePermissionKeys['manage_attendance']))
                <a href="#" onclick="return false;"><span class="menu-icon">📊</span><span>Manage Attendance</span><span class="soon">Soon</span></a>
                @endif

                @if(isset($activePermissionKeys['previous_attendance']))
                <a href="#" onclick="return false;"><span class="menu-icon">📁</span><span>Previous Attendance</span><span class="soon">Soon</span></a>
                @endif

                @if(isset($activePermissionKeys['readmission']))
                <a href="#" onclick="return false;"><span class="menu-icon">🔁</span><span>Readmission</span><span class="soon">Soon</span></a>
                @endif

                @if(isset($activePermissionKeys['house_exams']))
                <a href="#" onclick="return false;"><span class="menu-icon">📝</span><span>House Exams</span><span class="soon">Soon</span></a>
                @endif

                @if(isset($activePermissionKeys['marksheet_management']))
                <a href="#" onclick="return false;"><span class="menu-icon">📄</span><span>Marksheet Management</span><span class="soon">Soon</span></a>
                @endif

                @if(isset($activePermissionKeys['fee_concession']))
                <a href="#" onclick="return false;"><span class="menu-icon">💳</span><span>Fee Concession</span><span class="soon">Soon</span></a>
                @endif

                @if(isset($activePermissionKeys['online_fee_verification']))
                <a href="#" onclick="return false;"><span class="menu-icon">💻</span><span>Online Fee Verification</span><span class="soon">Soon</span></a>
                @endif

                @if(isset($activePermissionKeys['offline_fee_verification']))
                <a href="#" onclick="return false;"><span class="menu-icon">🧾</span><span>Offline Fee Verification</span><span class="soon">Soon</span></a>
                @endif

                @if(isset($activePermissionKeys['course_program_change']))
                <a href="#" onclick="return false;"><span class="menu-icon">🔄</span><span>Course / Program Change</span><span class="soon">Soon</span></a>
                @endif

                @if(isset($activePermissionKeys['university_data']))
                <a href="#" onclick="return false;"><span class="menu-icon">🏛️</span><span>University Data</span><span class="soon">Soon</span></a>
                @endif
            </nav>
        </aside>

        <main class="content">
            <div class="page-head">
                <div>
                    <p class="eyebrow">Student Management</p>
                    <h1>Registered Applicants</h1>
                    <p class="subtitle">View students with completed registration records for your assigned courses and academic sessions.</p>
                </div>
                <div class="assignment-pill">🎯 {{ $assignments->count() }} Active Assignment{{ $assignments->count() === 1 ? '' : 's' }}</div>
            </div>

            <section class="stats">
                <div class="stat"><div class="stat-label">Total Registered</div><div class="stat-value">{{ $totalRegistered }}</div></div>
                <div class="stat"><div class="stat-label">1st Year</div><div class="stat-value">{{ $yearCounts[1] ?? 0 }}</div></div>
                <div class="stat"><div class="stat-label">2nd Year</div><div class="stat-value">{{ $yearCounts[2] ?? 0 }}</div></div>
                <div class="stat"><div class="stat-label">3rd Year</div><div class="stat-value">{{ $yearCounts[3] ?? 0 }}</div></div>
                <div class="stat"><div class="stat-label">4th Year</div><div class="stat-value">{{ $yearCounts[4] ?? 0 }}</div></div>
            </section>

            <section class="panel">
                <div class="panel-head">
                    <div>
                        <h2 class="panel-title">Registered Student List</h2>
                        <p class="panel-help">Only active enrollments within your assigned course/session scope are displayed.</p>
                    </div>
                </div>

                <form method="GET" action="{{ route('staff.registered-applicants.index') }}" class="filters">
                    <div>
                        <label for="search">Search</label>
                        <input id="search" name="search" value="{{ $search }}" placeholder="Name, email, phone, college no., roll no.">
                    </div>

                    <div>
                        <label for="session_id">Academic Session</label>
                        <select id="session_id" name="session_id">
                            <option value="">All Sessions</option>
                            @foreach($sessionOptions as $session)
                                <option value="{{ $session->id }}" {{ $selectedSession === $session->id ? 'selected' : '' }}>{{ $session->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="course_id">Course / Programme</label>
                        <select id="course_id" name="course_id">
                            <option value="">All Courses</option>
                            @foreach($courseOptions as $course)
                                <option value="{{ $course->id }}" {{ $selectedCourse === $course->id ? 'selected' : '' }}>{{ $course->code }} — {{ $course->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="year_number">Year</label>
                        <select id="year_number" name="year_number">
                            <option value="">All Years</option>
                            @foreach([1 => '1st Year', 2 => '2nd Year', 3 => '3rd Year', 4 => '4th Year'] as $value => $label)
                                <option value="{{ $value }}" {{ $selectedYear === $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="semester_id">Semester</label>
                        <select id="semester_id" name="semester_id">
                            <option value="">All Semesters</option>
                            @foreach($semesterOptions as $semester)
                                <option value="{{ $semester->id }}" {{ $selectedSemester === $semester->id ? 'selected' : '' }}>{{ $semester->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:7px;">
                        <button class="filter-btn" type="submit">Filter</button>
                        <a class="reset-link" href="{{ route('staff.registered-applicants.index') }}">Reset</a>
                    </div>
                </form>

                @if($assignments->isEmpty())
                    <div class="notice" style="margin:16px 20px;">
                        No active academic assignments are configured for your staff profile. Please ask the administrator to assign at least one course and academic session.
                    </div>
                @endif

                @if($registeredStudents->count())
                    <div class="table-wrap">
                        <table>
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>College No.</th>
                                    <th>Roll No.</th>
                                    <th>Course</th>
                                    <th>Session</th>
                                    <th>Year / Semester</th>
                                    <th>Enrollment Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($registeredStudents as $enrollment)
                                    @php
                                        $student = $enrollment->student;
                                        $profile = $student?->studentProfile;
                                        $photoPath = $profile?->student_photo_path;
                                        $studentInitials = collect(preg_split('/\s+/', trim($student?->name ?? 'Student')))
                                            ->filter()
                                            ->map(fn ($part) => strtoupper(substr($part, 0, 1)))
                                            ->take(2)
                                            ->implode('');
                                    @endphp

                                    <tr>
                                        <td>
                                            <div class="student-cell">
                                                @if($photoPath)
                                                    <img class="photo" src="{{ asset('storage/' . $photoPath) }}" alt="Student Photo">
                                                @else
                                                    <div class="avatar-fallback">{{ $studentInitials ?: 'ST' }}</div>
                                                @endif
                                                <div>
                                                    <div class="student-name">{{ $student?->name ?? '-' }}</div>
                                                    <div class="student-sub">{{ $student?->email ?? '-' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><strong>{{ $enrollment->college_number ?? '-' }}</strong></td>
                                        <td>{{ $enrollment->roll_number ?? '-' }}</td>
                                        <td>
                                            <span class="course-code">{{ $enrollment->course?->code ?? 'COURSE' }}</span>
                                            <div style="margin-top:5px;max-width:190px;">{{ $enrollment->course?->name ?? '-' }}</div>
                                        </td>
                                        <td>{{ $enrollment->academicSession?->name ?? '-' }}</td>
                                        <td>
                                            <strong>{{ $enrollment->year_number ? 'Year ' . $enrollment->year_number : '-' }}</strong>
                                            @if($enrollment->currentSemester)
                                                <div class="student-sub">{{ $enrollment->currentSemester->name }}</div>
                                            @endif
                                        </td>
                                        <td class="date">{{ $enrollment->enrollment_date ? \Carbon\Carbon::parse($enrollment->enrollment_date)->format('d-m-Y') : '-' }}</td>
                                        <td><span class="status">● Active</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="pagination-wrap">
                        <div class="pagination-info">
                            Showing {{ $registeredStudents->firstItem() }}–{{ $registeredStudents->lastItem() }} of {{ $registeredStudents->total() }} students
                        </div>
                        <div class="pagination">
                            @if($registeredStudents->onFirstPage())
                                <span>‹</span>
                            @else
                                <a href="{{ $registeredStudents->previousPageUrl() }}">‹</a>
                            @endif

                            @foreach($registeredStudents->getUrlRange(max(1, $registeredStudents->currentPage() - 2), min($registeredStudents->lastPage(), $registeredStudents->currentPage() + 2)) as $page => $url)
                                @if($page == $registeredStudents->currentPage())
                                    <span class="active">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}">{{ $page }}</a>
                                @endif
                            @endforeach

                            @if($registeredStudents->hasMorePages())
                                <a href="{{ $registeredStudents->nextPageUrl() }}">›</a>
                            @else
                                <span>›</span>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="empty">
                        <div class="empty-icon">🎓</div>
                        <h3>No Registered Students Found</h3>
                        <p>There are currently no active registered students matching your assigned courses and selected filters.</p>
                    </div>
                @endif
            </section>
        </main>
    </div>
</body>
</html>
