<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Applicants — College ERP</title>
    <style>
        *{box-sizing:border-box}
        :root{--primary:#6948dc;--primary-dark:#4e35b5;--primary-light:#f0ecff;--sidebar:#2d2154;--sidebar-hover:#443374;--text:#202943;--muted:#66738a;--border:#e3e8f1;--bg:#f3f5fa;--white:#fff;--green:#11976c;--green-light:#e7f8f0;--red:#d9435b;--red-light:#fff0f2;--amber:#b7790b;--amber-light:#fff5df;--shadow:0 10px 28px rgba(30,41,59,.07)}
        html{-webkit-text-size-adjust:100%;text-rendering:optimizeLegibility}
        body{margin:0;font-family:"Segoe UI",Inter,Roboto,Arial,sans-serif;background:var(--bg);color:var(--text);-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale;font-size:14px}
        .topbar{height:70px;display:flex;align-items:center;justify-content:space-between;gap:16px;padding:0 24px;color:#fff;background:linear-gradient(100deg,#7650e5 0%,#6745d4 54%,#573abe 100%);box-shadow:0 7px 22px rgba(79,54,195,.2);position:sticky;top:0;z-index:20}
        .brand{display:flex;align-items:center;gap:12px;font-weight:850;font-size:20px;letter-spacing:.1px}.brand-icon{width:39px;height:39px;border-radius:12px;background:rgba(255,255,255,.16);display:grid;place-items:center;font-size:20px;border:1px solid rgba(255,255,255,.19)}
        .top-right{display:flex;align-items:center;gap:14px;font-weight:750;font-size:13px}.logout{border:0;color:#fff;background:#dd475e;padding:10px 15px;border-radius:10px;font-weight:850;cursor:pointer}.logout:hover{background:#c93650}
        .layout{display:flex;min-height:calc(100vh - 70px)}.sidebar{width:255px;flex:0 0 255px;background:linear-gradient(180deg,var(--sidebar),#261c49);color:#fff;padding:17px 12px;position:sticky;top:70px;height:calc(100vh - 70px);overflow-y:auto}.side-title{color:#cfc7ed;font-size:11px;font-weight:900;letter-spacing:1px;text-transform:uppercase;padding:2px 10px 12px}
        .staff-box{display:flex;align-items:center;gap:11px;padding:12px;border-radius:15px;background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.09);margin:0 1px 16px}.avatar{width:43px;height:43px;flex:0 0 43px;border-radius:13px;background:linear-gradient(135deg,#8c6ef5,#5b3fd2);display:grid;place-items:center;font-size:14px;font-weight:900}.staff-name{font-weight:850;font-size:13px;line-height:1.3}.staff-code{margin-top:3px;color:#bbb1df;font-size:11px;font-weight:700}
        .menu{display:flex;flex-direction:column;gap:5px}.menu a{display:flex;align-items:center;gap:10px;text-decoration:none;color:#f5f2ff;padding:11px 12px;border-radius:11px;font-size:13px;font-weight:750;line-height:1.35;transition:background .15s}.menu a:hover{background:rgba(255,255,255,.09)}.menu a.active{background:linear-gradient(90deg,#6948db,#7852ed);box-shadow:0 7px 18px rgba(70,45,170,.27)}.menu-icon{width:23px;flex:0 0 23px;text-align:center;font-size:16px}.soon{margin-left:auto;border-radius:999px;padding:3px 6px;background:rgba(255,255,255,.1);color:#d5cffa;font-size:9px;font-weight:900;text-transform:uppercase}
        .content{flex:1;min-width:0;padding:25px;background:radial-gradient(circle at 100% 0,rgba(105,72,220,.08),transparent 24%),linear-gradient(180deg,#f8f9fc,#f1f4f9)}.page-head{display:flex;align-items:flex-start;justify-content:space-between;gap:18px;margin-bottom:20px}.eyebrow{margin:0 0 5px;color:var(--primary);font-size:12px;font-weight:900;letter-spacing:.9px;text-transform:uppercase}h1{margin:0;font-size:29px;line-height:1.2;letter-spacing:-.5px;font-weight:900;color:#2a3150}.subtitle{margin:8px 0 0;color:var(--muted);font-size:14px;line-height:1.55;font-weight:550}.assignment-pill{background:#fff;border:1px solid #ded8fa;color:var(--primary-dark);padding:11px 14px;border-radius:13px;font-size:12px;font-weight:850;white-space:nowrap;box-shadow:0 6px 17px rgba(31,41,55,.05)}
        .stats{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:14px;margin-bottom:18px}.stat{background:#fff;border:1px solid var(--border);border-radius:16px;padding:16px 18px;box-shadow:var(--shadow);position:relative;overflow:hidden}.stat:after{content:"";position:absolute;width:75px;height:75px;border-radius:50%;right:-24px;top:-26px;background:var(--primary-light)}.stat-label{position:relative;z-index:1;color:var(--muted);font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:.6px}.stat-number{position:relative;z-index:1;margin-top:6px;color:var(--primary-dark);font-size:28px;font-weight:900}
        .panel{background:#fff;border:1px solid var(--border);border-radius:18px;box-shadow:var(--shadow);overflow:hidden}.panel-head{display:flex;align-items:center;justify-content:space-between;gap:15px;padding:18px 20px;border-bottom:1px solid var(--border)}.panel-title{margin:0;font-size:18px;font-weight:900}.panel-help{margin:5px 0 0;color:var(--muted);font-size:12px;line-height:1.5}.count-pill{background:var(--primary-light);color:var(--primary-dark);font-weight:900;font-size:12px;padding:8px 11px;border-radius:10px;white-space:nowrap}
        .filters{padding:17px 20px;background:#fbfcfe;border-bottom:1px solid var(--border);display:grid;grid-template-columns:minmax(220px,1fr) minmax(180px,.8fr) minmax(190px,.9fr) auto auto;gap:12px;align-items:end}.field label{display:block;margin-bottom:7px;color:#56627a;font-size:11px;font-weight:900;letter-spacing:.45px;text-transform:uppercase}.field select,.field input{width:100%;height:44px;border:1px solid #d8deea;border-radius:11px;padding:0 12px;background:#fff;color:var(--text);font-family:inherit;font-weight:650;font-size:13px;outline:none}.field select:focus,.field input:focus{border-color:#907aea;box-shadow:0 0 0 4px rgba(105,72,220,.1)}.btn{height:44px;border:0;border-radius:11px;padding:0 17px;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;font-family:inherit;font-size:12px;font-weight:900;cursor:pointer;white-space:nowrap}.btn-primary{color:#fff;background:linear-gradient(135deg,#714ce4,#5338c8)}.btn-primary:hover{filter:brightness(.96)}.btn-reset{border:1px solid #dfe4ed;background:#fff;color:#5f6b80}
        .notice{display:flex;align-items:flex-start;gap:11px;margin:18px 20px;padding:14px 16px;border-radius:13px;background:var(--amber-light);border:1px solid #f0d9a2;color:#805809;font-size:13px;line-height:1.55;font-weight:650}.notice-icon{font-size:19px}.notice a{color:#5d42c7;font-weight:900}
        .table-wrap{width:100%;overflow-x:auto}table{width:100%;min-width:1120px;border-collapse:collapse}th{padding:13px 14px;text-align:left;background:#f7f8fc;color:#66728a;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:.5px;border-bottom:1px solid var(--border);white-space:nowrap}td{padding:14px;border-bottom:1px solid #edf0f5;vertical-align:middle;font-size:13px;font-weight:600;color:#303a53}tbody tr:hover{background:#fbfaff}.student-cell{display:flex;align-items:center;gap:11px;min-width:210px}.photo,.fallback{width:43px;height:43px;flex:0 0 43px;border-radius:12px;object-fit:cover;border:2px solid #eeeaff;background:#f1efff}.fallback{display:grid;place-items:center;color:#5338bf;font-weight:900;background:linear-gradient(135deg,#e1d9ff,#b5a5f4)}.student-name{font-weight:900;color:#202943}.student-sub{color:#78839a;font-size:11px;margin-top:3px;font-weight:550}.course-code{display:inline-block;padding:5px 8px;background:#f0ecff;border-radius:8px;color:#4f35ba;font-size:10px;font-weight:900;white-space:nowrap}.status{display:inline-flex;align-items:center;gap:6px;padding:6px 9px;border-radius:999px;background:#fff5df;color:#a36a00;font-size:10px;font-weight:900;text-transform:uppercase;white-space:nowrap}.view-btn{display:inline-flex;align-items:center;justify-content:center;padding:9px 12px;border-radius:9px;background:linear-gradient(135deg,#714ce4,#5338c8);color:white;text-decoration:none;font-size:11px;font-weight:900;white-space:nowrap}.view-btn:hover{filter:brightness(.96)}.date{white-space:nowrap}
        .empty{padding:47px 20px;text-align:center}.empty-icon{width:62px;height:62px;margin:0 auto 12px;border-radius:20px;background:#f0ecff;display:grid;place-items:center;font-size:29px}.empty h3{margin:0;font-size:18px;font-weight:900;color:#28314e}.empty p{max-width:650px;margin:8px auto 0;color:var(--muted);font-size:13px;line-height:1.6}.empty .hint{display:inline-block;margin-top:15px;background:#f6f3ff;padding:9px 12px;border-radius:10px;color:#5742b8;font-size:12px;font-weight:800}
        .pagination-wrap{padding:16px 20px;display:flex;justify-content:space-between;align-items:center;gap:12px;border-top:1px solid var(--border)}.pagination-info{color:var(--muted);font-size:12px;font-weight:650}.pagination{display:flex;gap:6px;flex-wrap:wrap}.pagination a,.pagination span{min-width:34px;height:34px;padding:0 10px;border:1px solid #dfe3ea;border-radius:9px;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;color:#576175;font-size:12px;font-weight:900;background:#fff}.pagination .active{background:var(--primary);color:#fff;border-color:var(--primary)}.alert{margin-bottom:16px;padding:13px 15px;border-radius:12px;font-size:13px;font-weight:750}.alert-success{background:var(--green-light);color:#08754e;border:1px solid #bce8d5}.alert-error{background:var(--red-light);color:#a92e45;border:1px solid #f2c4cc}
        @media(max-width:1250px){.filters{grid-template-columns:repeat(2,minmax(0,1fr))}.filters-actions{display:flex;gap:8px}.stats{grid-template-columns:repeat(3,minmax(0,1fr))}}
        @media(max-width:850px){.sidebar{width:225px;flex-basis:225px}.content{padding:18px}.page-head{flex-direction:column}.topbar{padding:0 16px}.brand{font-size:17px}}
        @media(max-width:650px){.layout{display:block}.sidebar{position:static;width:100%;height:auto}.content{padding:14px}.stats{grid-template-columns:1fr 1fr}.filters{grid-template-columns:1fr}.page-head h1{font-size:24px}.panel-head{align-items:flex-start;flex-direction:column}.top-right>span{display:none}.brand{font-size:15px}.pagination-wrap{align-items:flex-start;flex-direction:column}}
    </style>
</head>
<body>
<header class="topbar">
    <div class="brand"><span class="brand-icon">🎓</span><span>College ERP — Unit Teacher Panel</span></div>
    <div class="top-right"><span>{{ auth()->user()->name ?? 'Staff' }}</span><form method="POST" action="{{ route('staff.logout') }}">@csrf<button class="logout" type="submit">Logout</button></form></div>
</header>
<div class="layout">
    <aside class="sidebar">
        <div class="side-title">Staff Menu</div>
        @php
            $staffName = auth()->user()->name ?? 'Staff';
            $initials = collect(preg_split('/\s+/', trim($staffName)))->filter()->map(fn($part) => strtoupper(substr($part, 0, 1)))->take(2)->implode('');
            $today = now()->toDateString();
            $activePermissionKeys = isset($staffProfile) && $staffProfile
                ? $staffProfile->permissions()->where('is_active', true)
                    ->where(function ($query) use ($today) { $query->whereNull('start_date')->orWhereDate('start_date', '<=', $today); })
                    ->where(function ($query) use ($today) { $query->whereNull('end_date')->orWhereDate('end_date', '>=', $today); })
                    ->pluck('permission_key')->flip()
                : collect()->flip();
            $courseOptions = $courses ?? $courseOptions ?? collect();
            $semesterOptions = $semesters ?? $semesterOptions ?? collect();
            $applicationRows = $applications ?? $submittedApplications ?? $newApplicants ?? collect();
            $selectedCourseValue = (string) ($selectedCourse ?? request('course_id', ''));
            $selectedSemesterValue = (string) ($selectedSemester ?? request('semester_id', ''));
            $assignmentCount = isset($assignments) ? $assignments->count() : $courseOptions->count();
        @endphp
        <div class="staff-box"><div class="avatar">{{ $initials ?: 'ST' }}</div><div><div class="staff-name">{{ $staffName }}</div><div class="staff-code">{{ $staffProfile->employee_code ?? 'Unit Teacher' }}</div></div></div>
        <nav class="menu">
            <a href="{{ route('staff.dashboard') }}"><span class="menu-icon">🏠</span><span>Dashboard</span></a>
            @if(isset($activePermissionKeys['new_applicants']))<a class="active" href="{{ route('staff.applications.index') }}"><span class="menu-icon">📝</span><span>New Applicants</span></a>@endif
            @if(isset($activePermissionKeys['registered_applicants']))<a href="{{ route('staff.registered-applicants.index') }}"><span class="menu-icon">🎓</span><span>Registered Applicants</span></a>@endif
            @if(isset($activePermissionKeys['manage_attendance']))<a href="#" onclick="return false"><span class="menu-icon">📊</span><span>Manage Attendance</span><span class="soon">Soon</span></a>@endif
            @if(isset($activePermissionKeys['previous_attendance']))<a href="#" onclick="return false"><span class="menu-icon">📁</span><span>Previous Attendance</span><span class="soon">Soon</span></a>@endif
            @if(isset($activePermissionKeys['readmission']))<a href="#" onclick="return false"><span class="menu-icon">🔄</span><span>Readmission</span><span class="soon">Soon</span></a>@endif
            @if(isset($activePermissionKeys['house_exams']))<a href="#" onclick="return false"><span class="menu-icon">📝</span><span>House Exams</span><span class="soon">Soon</span></a>@endif
            @if(isset($activePermissionKeys['marksheet_management']))<a href="#" onclick="return false"><span class="menu-icon">📄</span><span>Marksheet Management</span><span class="soon">Soon</span></a>@endif
            @if(isset($activePermissionKeys['fee_concession']))<a href="#" onclick="return false"><span class="menu-icon">💳</span><span>Fee Concession</span><span class="soon">Soon</span></a>@endif
            @if(isset($activePermissionKeys['online_fee_verification']))<a href="#" onclick="return false"><span class="menu-icon">💻</span><span>Online Fee Verification</span><span class="soon">Soon</span></a>@endif
            @if(isset($activePermissionKeys['offline_fee_verification']))<a href="{{ route('staff.fee-verification.index') }}"><span class="menu-icon">🧾</span><span>Offline Fee Verification</span></a>@endif
            @if(isset($activePermissionKeys['course_program_change']))<a href="#" onclick="return false"><span class="menu-icon">🔁</span><span>Course / Program Change</span><span class="soon">Soon</span></a>@endif
            @if(isset($activePermissionKeys['university_data']))<a href="#" onclick="return false"><span class="menu-icon">🏛️</span><span>University Data</span><span class="soon">Soon</span></a>@endif
        </nav>
    </aside>

    <main class="content">
        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        @if(session('error'))<div class="alert alert-error">{{ session('error') }}</div>@endif
        <div class="page-head">
            <div><p class="eyebrow">Admissions • Step 5 Review</p><h1>New Applicants</h1><p class="subtitle">Review submitted final registration forms for the courses, semesters and academic sessions assigned to you.</p></div>
            <div class="assignment-pill">🗂️ {{ $assignmentCount }} Active Course Assignment{{ $assignmentCount === 1 ? '' : 's' }}</div>
        </div>

        <section class="stats">
            <div class="stat"><div class="stat-label">Submitted Applications</div><div class="stat-number">{{ method_exists($applicationRows, 'total') ? $applicationRows->total() : $applicationRows->count() }}</div></div>
            <div class="stat"><div class="stat-label">Assigned Courses</div><div class="stat-number">{{ $courseOptions->count() }}</div></div>
            <div class="stat"><div class="stat-label">Semester Options</div><div class="stat-number">{{ $semesterOptions->count() }}</div></div>
        </section>

        <section class="panel">
            <div class="panel-head"><div><h2 class="panel-title">Applications Awaiting Verification</h2><p class="panel-help">Only submitted applications matching your active academic assignments are displayed. Open a form to approve or reject it with remarks.</p></div><span class="count-pill">{{ method_exists($applicationRows, 'total') ? $applicationRows->total() : $applicationRows->count() }} application(s)</span></div>
            <form method="GET" action="{{ route('staff.applications.index') }}" class="filters">
                <div class="field"><label for="course_id">Course / Programme</label><select id="course_id" name="course_id"><option value="">All Assigned Courses</option>@foreach($courseOptions as $course)<option value="{{ $course->id }}" {{ $selectedCourseValue === (string) $course->id ? 'selected' : '' }}>{{ $course->code ?? '' }}{{ !empty($course->code) ? ' — ' : '' }}{{ $course->name ?? 'Course '.$course->id }}</option>@endforeach</select></div>
                <div class="field"><label for="semester_id">Semester / Year</label><select id="semester_id" name="semester_id"><option value="">All Assigned Semesters</option>@foreach($semesterOptions as $semester)<option value="{{ $semester->id }}" {{ $selectedSemesterValue === (string) $semester->id ? 'selected' : '' }}>{{ $semester->name }}{{ isset($semester->semester_number) ? ' ('.$semester->semester_number.')' : '' }}</option>@endforeach</select></div>
                <button class="btn btn-primary" type="submit">Filter Applications</button>
                <a class="btn btn-reset" href="{{ route('staff.applications.index') }}">Reset</a>
            </form>

            @if($assignmentCount === 0)
                <div class="notice"><span class="notice-icon">⚠️</span><div><strong>No active course assignment found.</strong><br>The module permission is enabled, but the administrator has not assigned a course and academic session to this teacher yet. Sign in to the Admin panel and open <strong>Staff Management → Department Assignment</strong>, then assign the teacher to the student's course and the correct session (for example, 2026-27). If the Department Assignment page shows 403, open it in a separate browser/private window and sign in as the administrator first.</div></div>
            @endif

            @if($applicationRows->count())
                <div class="table-wrap"><table><thead><tr><th>S. No.</th><th>Application No.</th><th>Student</th><th>Father's Name</th><th>Course / Programme</th><th>Academic Session</th><th>Semester / Year</th><th>Submitted On</th><th>Status</th><th>Action</th></tr></thead><tbody>
                @foreach($applicationRows as $index => $application)
                    @php
                        $student = $application->student ?? null;
                        $profile = $student?->studentProfile;
                        $photoPath = $profile?->student_photo_path;
                        $studentInitials = collect(preg_split('/\s+/', trim($student?->name ?? 'Student')))->filter()->map(fn($part) => strtoupper(substr($part, 0, 1)))->take(2)->implode('');
                        $semesterNumber = (int) ($application->semester?->semester_number ?? 0);
                        $yearNumber = $semesterNumber > 0 ? (int) ceil($semesterNumber / 2) : null;
                        $submittedOn = $application->submitted_at ?? $application->created_at ?? null;
                    @endphp
                    <tr>
                        <td>{{ method_exists($applicationRows, 'firstItem') ? $applicationRows->firstItem() + $index : $index + 1 }}</td>
                        <td><strong>{{ $application->application_no ?? ('APP-'.$application->id) }}</strong></td>
                        <td><div class="student-cell">@if($photoPath)<img class="photo" src="{{ asset('storage/'.$photoPath) }}" alt="Student Photo">@else<div class="fallback">{{ $studentInitials ?: 'ST' }}</div>@endif<div><div class="student-name">{{ $student?->name ?? '-' }}</div><div class="student-sub">{{ $student?->phone ?? $student?->email ?? '-' }}</div></div></div></td>
                        <td>{{ $profile?->father_name ?? '-' }}</td>
                        <td><span class="course-code">{{ $application->course?->code ?? 'COURSE' }}</span><div style="margin-top:5px;max-width:210px">{{ $application->course?->name ?? '-' }}</div></td>
                        <td>{{ $application->session?->name ?? '-' }}</td>
                        <td>@if($application->semester)<strong>{{ $application->semester->name }}</strong>@if($yearNumber)<div class="student-sub">Year {{ $yearNumber }}</div>@endif @else <strong>Yearly Programme</strong> @endif</td>
                        <td class="date">{{ $submittedOn ? \Illuminate\Support\Carbon::parse($submittedOn)->format('d M Y, h:i A') : '-' }}</td>
                        <td><span class="status">● {{ strtoupper(str_replace('_', ' ', $application->status ?? 'submitted')) }}</span></td>
                        <td><a class="view-btn" href="{{ route('staff.applications.show', $application->id) }}">View & Verify</a></td>
                    </tr>
                @endforeach
                </tbody></table></div>
                @if(method_exists($applicationRows, 'links'))<div class="pagination-wrap"><div class="pagination-info">Showing {{ $applicationRows->firstItem() }}–{{ $applicationRows->lastItem() }} of {{ $applicationRows->total() }} applications</div><div class="pagination">{{ $applicationRows->onEachSide(1)->links('pagination::simple-tailwind') }}</div></div>@endif
            @else
                <div class="empty"><div class="empty-icon">📝</div><h3>No Submitted Applications Found</h3>
                @if($assignmentCount === 0)
                    <p>Once the administrator assigns this teacher to the matching course and academic session, matching student submissions will appear here.</p><span class="hint">Check Staff Management → Department Assignment</span>
                @else
                    <p>No submitted student applications currently match your assigned course, academic session and semester. If a student has submitted the form, ask the administrator to confirm the application course/session/semester matches your active assignment.</p>
                @endif
                </div>
            @endif
        </section>
    </main>
</div>
</body>
</html>
