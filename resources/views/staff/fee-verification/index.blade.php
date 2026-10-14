<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offline Fee Verification — College ERP</title>
    <style>
        *{box-sizing:border-box}
        :root{
            --primary:#6246e5;--primary2:#4f35c8;--navy:#19133f;
            --bg:#f4f6fb;--text:#20263a;--muted:#718096;--border:#e2e6ef;
            --success:#15965e;--success-bg:#eafaf2;--warning:#bc7600;--warning-bg:#fff6df;
            --danger:#d93652;--danger-bg:#ffedf1;--teal:#08a3b7;--teal-bg:#e9fbfd;
            --shadow:0 14px 36px rgba(31,41,55,.08)
        }
        html{-webkit-text-size-adjust:100%;text-rendering:optimizeLegibility}
        body{margin:0;font-family:"Segoe UI",Inter,Roboto,Arial,sans-serif;background:var(--bg);color:var(--text);-webkit-font-smoothing:antialiased}
        .topbar{height:72px;background:linear-gradient(100deg,#734bea,#5d40d0 60%,#4d35bd);display:flex;align-items:center;justify-content:space-between;padding:0 24px;color:#fff;position:sticky;top:0;z-index:20;box-shadow:0 8px 24px rgba(79,54,195,.22)}
        .brand{display:flex;align-items:center;gap:12px;font-size:21px;font-weight:900}.brand-icon{width:40px;height:40px;border-radius:12px;display:grid;place-items:center;background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.22);font-size:20px}
        .top-right{display:flex;align-items:center;gap:14px;font-size:14px;font-weight:800}.logout{border:0;background:rgba(255,255,255,.16);color:#fff;padding:10px 15px;border-radius:10px;font-weight:900;cursor:pointer}
        .layout{display:flex;min-height:calc(100vh - 72px)}
        .sidebar{width:250px;flex:0 0 250px;background:linear-gradient(180deg,#241b4d,#2d205d);color:#fff;padding:18px 12px;position:sticky;top:72px;height:calc(100vh - 72px);overflow:auto}.sidebar-title{font-size:11px;font-weight:900;letter-spacing:1px;color:#cfc8ef;text-transform:uppercase;padding:0 10px 12px}.staff-box{display:flex;align-items:center;gap:11px;background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.09);padding:12px;border-radius:15px;margin-bottom:15px}.staff-avatar{width:43px;height:43px;border-radius:13px;background:linear-gradient(135deg,#8d70f4,#5e43d7);display:grid;place-items:center;font-weight:900}.staff-name{font-weight:900;font-size:14px}.staff-code{font-size:11px;color:#bbb2df;margin-top:2px;font-weight:700}.menu{display:flex;flex-direction:column;gap:5px}.menu a{display:flex;align-items:center;gap:10px;text-decoration:none;color:#f7f4ff;padding:11px 12px;border-radius:11px;font-size:13px;font-weight:800}.menu a:hover,.menu a.active{background:linear-gradient(90deg,#6948db,#7751ec);box-shadow:0 8px 18px rgba(71,46,170,.28)}.menu-icon{width:23px;text-align:center;font-size:16px}.soon{margin-left:auto;font-size:9px;padding:3px 6px;border-radius:999px;background:rgba(255,255,255,.1);color:#cbc4ea;font-weight:900;text-transform:uppercase}
        .content{flex:1;min-width:0;padding:24px;background:radial-gradient(circle at 100% 0%,rgba(98,70,229,.09),transparent 23%),linear-gradient(180deg,#f9fafc,#f0f3f8)}
        .page-head{display:flex;align-items:flex-start;justify-content:space-between;gap:18px;margin-bottom:18px}.eyebrow{margin:0 0 5px;color:var(--primary);font-size:12px;font-weight:900;text-transform:uppercase;letter-spacing:1px}.page-head h1{margin:0;font-size:30px;line-height:1.15;font-weight:950;letter-spacing:-.5px}.subtitle{margin:8px 0 0;color:var(--muted);font-size:14px;font-weight:600}.assignment{background:#fff;border:1px solid #ddd7fa;border-radius:13px;padding:11px 14px;color:var(--primary2);font-size:12px;font-weight:900;box-shadow:0 8px 20px rgba(31,41,55,.05);white-space:nowrap}
        .stats{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:14px;margin-bottom:18px}.stat{background:#fff;border:1px solid var(--border);border-radius:17px;padding:16px;box-shadow:var(--shadow);position:relative;overflow:hidden}.stat:nth-child(1){border-top:4px solid var(--primary)}.stat:nth-child(2){border-top:4px solid var(--teal)}.stat:nth-child(3){border-top:4px solid var(--warning)}.stat:nth-child(4){border-top:4px solid var(--success)}.stat-label{font-size:11px;color:var(--muted);font-weight:900;text-transform:uppercase;letter-spacing:.6px}.stat-value{margin-top:5px;font-size:29px;font-weight:950;color:var(--navy)}
        .panel{background:#fff;border:1px solid var(--border);border-radius:18px;box-shadow:var(--shadow);overflow:hidden}.panel-head{padding:18px 20px;border-bottom:1px solid var(--border);display:flex;justify-content:space-between;gap:15px;align-items:center}.panel-title{margin:0;font-size:19px;font-weight:950}.panel-help{margin:5px 0 0;color:var(--muted);font-size:12px;font-weight:600}
        .filters{display:grid;grid-template-columns:1.45fr repeat(3,1fr) auto;gap:10px;padding:16px 20px;background:#fbfcfe;border-bottom:1px solid var(--border);align-items:end}.field label{display:block;margin-bottom:6px;font-size:11px;font-weight:900;color:#596579;text-transform:uppercase;letter-spacing:.5px}.field input,.field select{width:100%;height:43px;border:1px solid #d9deea;border-radius:11px;background:#fff;padding:0 12px;font-family:inherit;font-size:13px;font-weight:650;outline:none}.field input:focus,.field select:focus{border-color:#8d79eb;box-shadow:0 0 0 4px rgba(98,70,229,.1)}.btn{border:0;height:43px;border-radius:11px;padding:0 17px;font-family:inherit;font-size:12px;font-weight:900;cursor:pointer}.btn-primary{color:#fff;background:linear-gradient(135deg,#6e4be4,#5136c9)}.btn-reset{background:#fff;color:#5f687b;border:1px solid #dfe3ea;text-decoration:none;display:inline-flex;align-items:center;justify-content:center}
        .table-wrap{overflow:auto}table{width:100%;min-width:1280px;border-collapse:collapse}th{padding:13px 13px;background:linear-gradient(180deg,#ffd91a,#ffd000);border-bottom:1px solid #e2ba00;color:#1d2440;text-align:left;font-size:11px;font-weight:950;text-transform:uppercase;letter-spacing:.35px}td{padding:14px 13px;border-bottom:1px solid #edf0f4;font-size:13px;font-weight:650;color:#2c3650;vertical-align:middle}tbody tr:hover{background:#fcfbff}
        .student{display:flex;align-items:center;gap:10px;min-width:225px}.photo,.fallback{width:46px;height:54px;border-radius:10px;flex:0 0 46px}.photo{object-fit:cover;border:2px solid #ece8ff}.fallback{display:grid;place-items:center;background:linear-gradient(135deg,#e1dbff,#9d8ae7);color:#4c35b7;font-weight:950}.student-name{font-size:14px;font-weight:900;color:#1e2740}.student-sub{font-size:11px;color:#788397;margin-top:2px}.badge{display:inline-flex;align-items:center;gap:6px;padding:6px 9px;border-radius:999px;font-size:10px;font-weight:950;text-transform:uppercase}.badge-approved{background:var(--success-bg);color:var(--success)}.badge-pending{background:var(--warning-bg);color:var(--warning)}.course{font-weight:900;color:var(--primary2)}.meta{font-size:11px;color:#7b8598;margin-top:3px}.fee-cell{min-width:205px}.fee-form{display:grid;grid-template-columns:1fr 1fr;gap:6px}.fee-form input,.fee-form select{width:100%;height:34px;border:1px solid #dce1ea;border-radius:8px;padding:0 8px;font-family:inherit;font-size:11px;font-weight:650}.fee-form .full{grid-column:1/-1}.verify-btn{grid-column:1/-1;height:36px;border:0;border-radius:8px;background:linear-gradient(135deg,#15965e,#0b7f4e);color:#fff;font-family:inherit;font-size:11px;font-weight:950;cursor:pointer}.empty{text-align:center;padding:60px 20px}.empty-icon{width:65px;height:65px;border-radius:21px;margin:0 auto 12px;background:#f0ecff;display:grid;place-items:center;font-size:29px}.empty h3{margin:0;font-size:18px;font-weight:950}.empty p{margin:7px 0 0;color:var(--muted);font-size:13px}.notice{margin:16px 20px;padding:13px 15px;border-radius:13px;background:var(--warning-bg);border:1px solid #f0d99b;color:#7c5200;font-size:12px;font-weight:700}.alert{margin-bottom:16px;padding:13px 15px;border-radius:13px;font-size:13px;font-weight:750}.alert-success{background:var(--success-bg);color:#0c7046;border:1px solid #bfead4}.alert-error{background:var(--danger-bg);color:#9f1934;border:1px solid #f4c3cf}
        .pagination-wrap{padding:15px 20px;display:flex;justify-content:space-between;align-items:center;gap:12px;border-top:1px solid var(--border)}.pagination-info{font-size:12px;color:var(--muted);font-weight:650}.pagination{display:flex;gap:6px;flex-wrap:wrap}.pagination a,.pagination span{min-width:34px;height:34px;border:1px solid #dfe3ea;background:#fff;color:#576175;border-radius:9px;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;font-size:12px;font-weight:900}.pagination .active{background:var(--primary);color:#fff;border-color:var(--primary)}
        @media(max-width:1180px){.stats{grid-template-columns:repeat(2,minmax(0,1fr))}.filters{grid-template-columns:repeat(2,minmax(0,1fr))}}@media(max-width:850px){.sidebar{width:220px;flex-basis:220px}.content{padding:18px}.page-head{flex-direction:column}}@media(max-width:700px){.layout{display:block}.sidebar{position:static;width:auto;height:auto;display:none}.content{padding:14px}.stats{grid-template-columns:1fr}.filters{grid-template-columns:1fr}.topbar{padding:0 14px}.top-right>span{display:none}.brand{font-size:17px}.page-head h1{font-size:25px}}
    </style>
</head>
<body>
<header class="topbar">
    <div class="brand"><span class="brand-icon">🧾</span>College ERP — Unit Teacher Panel</div>
    <div class="top-right"><span>{{ auth()->user()->name }}</span><form method="POST" action="{{ route('staff.logout') }}">@csrf<button class="logout">Logout</button></form></div>
</header>
<div class="layout">
<aside class="sidebar">
    <div class="sidebar-title">Staff Menu</div>
    @php
        $staffName = auth()->user()->name ?? 'Staff';
        $initials = collect(preg_split('/\s+/', trim($staffName)))->filter()->map(fn($part)=>strtoupper(substr($part,0,1)))->take(2)->implode('');
        $today = now()->toDateString();
        $activePermissionKeys = $staffProfile->permissions()->where('is_active',true)->where(function($q)use($today){$q->whereNull('start_date')->orWhereDate('start_date','<=',$today);})->where(function($q)use($today){$q->whereNull('end_date')->orWhereDate('end_date','>=',$today);})->pluck('permission_key')->flip();
    @endphp
    <div class="staff-box"><div class="staff-avatar">{{ $initials ?: 'ST' }}</div><div><div class="staff-name">{{ $staffName }}</div><div class="staff-code">{{ $staffProfile->employee_code ?? '-' }}</div></div></div>
    <nav class="menu">
        <a href="{{ route('staff.dashboard') }}"><span class="menu-icon">🏠</span><span>Dashboard</span></a>
        @if(isset($activePermissionKeys['new_applicants']))<a href="{{ route('staff.applications.index') }}"><span class="menu-icon">📝</span><span>New Applicants</span></a>@endif
        @if(isset($activePermissionKeys['registered_applicants']))<a href="{{ route('staff.registered-applicants.index') }}"><span class="menu-icon">🎓</span><span>Registered Applicants</span></a>@endif
        @if(isset($activePermissionKeys['offline_fee_verification']))<a class="active" href="{{ route('staff.fee-verification.index') }}"><span class="menu-icon">🧾</span><span>Offline Fee Verification</span></a>@endif
        @if(isset($activePermissionKeys['manage_attendance']))<a href="#" onclick="return false"><span class="menu-icon">📊</span><span>Manage Attendance</span><span class="soon">Soon</span></a>@endif
        @if(isset($activePermissionKeys['previous_attendance']))<a href="#" onclick="return false"><span class="menu-icon">📁</span><span>Previous Attendance</span><span class="soon">Soon</span></a>@endif
        @if(isset($activePermissionKeys['readmission']))<a href="#" onclick="return false"><span class="menu-icon">🔄</span><span>Readmission</span><span class="soon">Soon</span></a>@endif
        @if(isset($activePermissionKeys['house_exams']))<a href="#" onclick="return false"><span class="menu-icon">📝</span><span>House Exams</span><span class="soon">Soon</span></a>@endif
        @if(isset($activePermissionKeys['marksheet_management']))<a href="#" onclick="return false"><span class="menu-icon">📄</span><span>Marksheet Management</span><span class="soon">Soon</span></a>@endif
    </nav>
</aside>
<main class="content">
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="alert alert-error">{{ session('error') }}</div>@endif
    @if($errors->any())<div class="alert alert-error">{{ $errors->first() }}</div>@endif

    <div class="page-head">
        <div><p class="eyebrow">Finance / Admission</p><h1>Offline Fee Verification</h1><p class="subtitle">Verify the student's first fee installment after the admission form has been approved. Successful verification creates the official college student record.</p></div>
        <div class="assignment">🎯 {{ $assignments->count() }} Active Assignment{{ $assignments->count()===1?'':'s' }}</div>
    </div>

    <section class="stats">
        <div class="stat"><div class="stat-label">Pending First Fee</div><div class="stat-value">{{ $pendingFirstFee }}</div></div>
        <div class="stat"><div class="stat-label">Assigned Courses</div><div class="stat-value">{{ $courseOptions->count() }}</div></div>
        <div class="stat"><div class="stat-label">Assigned Sessions</div><div class="stat-value">{{ $sessionOptions->count() }}</div></div>
        <div class="stat"><div class="stat-label">Installment</div><div class="stat-value">1</div></div>
    </section>

    <section class="panel">
        <div class="panel-head"><div><h2 class="panel-title">Students Ready for First Fee Verification</h2><p class="panel-help">Only approved applications in the logged-in teacher's academic assignment scope are shown.</p></div></div>
        <form method="GET" action="{{ route('staff.fee-verification.index') }}" class="filters">
            <div class="field"><label for="search">Search</label><input id="search" name="search" value="{{ $search }}" placeholder="Name, email, phone or application no."></div>
            <div class="field"><label for="session_id">Academic Session</label><select id="session_id" name="session_id"><option value="">All Sessions</option>@foreach($sessionOptions as $session)<option value="{{ $session->id }}" {{ $selectedSession===$session->id?'selected':'' }}>{{ $session->name }}</option>@endforeach</select></div>
            <div class="field"><label for="course_id">Course / Programme</label><select id="course_id" name="course_id"><option value="">All Courses</option>@foreach($courseOptions as $course)<option value="{{ $course->id }}" {{ $selectedCourse===$course->id?'selected':'' }}>{{ $course->code }} — {{ $course->name }}</option>@endforeach</select></div>
            <div class="field"><label for="semester_id">Semester</label><select id="semester_id" name="semester_id"><option value="">All Semesters</option>@foreach($semesterOptions as $semester)<option value="{{ $semester->id }}" {{ $selectedSemester===$semester->id?'selected':'' }}>{{ $semester->name }}</option>@endforeach</select></div>
            <div style="display:flex;gap:7px"><button class="btn btn-primary" type="submit">Search</button><a class="btn btn-reset" href="{{ route('staff.fee-verification.index') }}">Reset</a></div>
        </form>

        @if($assignments->isEmpty())<div class="notice">No active course/session assignment is configured for this staff account. Ask the administrator to assign the required course and session.</div>@endif

        @if($applications->count())
        <div class="table-wrap"><table><thead><tr><th>S.No.</th><th>Application / Student</th><th>Course / Session</th><th>Year / Semester</th><th>Form Status</th><th>First Fee Details & Verification</th></tr></thead><tbody>
        @foreach($applications as $index=>$application)
            @php
                $student=$application->student;
                $profile=$student?->studentProfile;
                $photo=$profile?->student_photo_path;
                $initials=collect(preg_split('/\s+/',trim($student?->name??'Student')))->filter()->map(fn($p)=>strtoupper(substr($p,0,1)))->take(2)->implode('');
                $semNo=(int)($application->semester?->semester_number??0);
                $year=$semNo>0?(int)ceil($semNo/2):1;
            @endphp
            <tr>
                <td>{{ $applications->firstItem()+$index }}</td>
                <td><div class="student">@if($photo)<img class="photo" src="{{ asset('storage/'.$photo) }}" alt="Student Photo">@else<div class="fallback">{{ $initials?:'ST' }}</div>@endif<div><div class="student-name">{{ $student?->name??'-' }}</div><div class="student-sub">Application: {{ $application->application_no??$application->id }}<br>{{ $student?->phone??$student?->email??'-' }}</div></div></div></td>
                <td><div class="course">{{ $application->course?->code??'-' }}</div><div>{{ $application->course?->name??'-' }}</div><div class="meta">{{ $application->session?->name??'-' }}</div></td>
                <td><strong>Year {{ $year }}</strong><div class="meta">{{ $application->semester?->name??'Yearly Programme' }}</div></td>
                <td><span class="badge badge-approved">● FORM VERIFIED</span></td>
                <td class="fee-cell"><form method="POST" action="{{ route('staff.fee-verification.verify-first-fee',$application->id) }}" class="fee-form">@csrf<input name="amount_paid" type="number" min="0.01" step="0.01" placeholder="Amount Paid *" required><select name="payment_mode" required><option value="">Payment Mode *</option><option value="cash">Cash</option><option value="bank_transfer">Bank Transfer</option><option value="upi">UPI</option><option value="card">Card</option><option value="other">Other</option></select><input name="receipt_number" class="full" placeholder="Receipt Number *" required><input name="payment_date" type="date" class="full" value="{{ now()->format('Y-m-d') }}" required><input name="remarks" class="full" placeholder="Remarks (optional)"><button class="verify-btn" type="submit" onclick="return confirm('Verify the first fee and create the official College Student record for this applicant?')">✓ VERIFY FIRST FEE &amp; ENROLL</button></form></td>
            </tr>
        @endforeach
        </tbody></table></div>
        <div class="pagination-wrap"><div class="pagination-info">Showing {{ $applications->firstItem() }}–{{ $applications->lastItem() }} of {{ $applications->total() }}</div><div class="pagination">@if($applications->onFirstPage())<span>‹</span>@else<a href="{{ $applications->previousPageUrl() }}">‹</a>@endif@foreach($applications->getUrlRange(max(1,$applications->currentPage()-2),min($applications->lastPage(),$applications->currentPage()+2)) as $page=>$url)@if($page==$applications->currentPage())<span class="active">{{ $page }}</span>@else<a href="{{ $url }}">{{ $page }}</a>@endif@endforeach@if($applications->hasMorePages())<a href="{{ $applications->nextPageUrl() }}">›</a>@else<span>›</span>@endif</div></div>
        @else
        <div class="empty"><div class="empty-icon">💳</div><h3>No Students Pending First Fee Verification</h3><p>Once a Unit Teacher approves an admission form, the student will appear here for first fee verification.</p></div>
        @endif
    </section>
</main>
</div>
</body>
</html>
