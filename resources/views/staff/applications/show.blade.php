<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Verification — College ERP</title>
    <style>
        *{box-sizing:border-box}
        :root{--primary:#6948dc;--primary-dark:#4e35b5;--primary-light:#f0ecff;--sidebar:#2d2154;--sidebar-hover:#443374;--text:#202943;--muted:#66738a;--border:#e3e8f1;--bg:#f3f5fa;--white:#fff;--green:#11976c;--green-light:#e7f8f0;--red:#d9435b;--red-light:#fff0f2;--amber:#b7790b;--amber-light:#fff5df;--shadow:0 10px 28px rgba(30,41,59,.07)}
        html{-webkit-text-size-adjust:100%;text-rendering:optimizeLegibility}
        body{margin:0;font-family:"Segoe UI",Inter,Roboto,Arial,sans-serif;background:var(--bg);color:var(--text);-webkit-font-smoothing:antialiased;font-size:14px}
        .topbar{height:70px;display:flex;align-items:center;justify-content:space-between;gap:16px;padding:0 24px;color:#fff;background:linear-gradient(100deg,#7650e5 0%,#6745d4 54%,#573abe 100%);box-shadow:0 7px 22px rgba(79,54,195,.2);position:sticky;top:0;z-index:20}
        .brand{display:flex;align-items:center;gap:12px;font-weight:850;font-size:20px;letter-spacing:.1px}.brand-icon{width:39px;height:39px;border-radius:12px;background:rgba(255,255,255,.16);display:grid;place-items:center;font-size:20px;border:1px solid rgba(255,255,255,.19)}
        .top-right{display:flex;align-items:center;gap:14px;font-weight:750;font-size:13px}.logout{border:0;color:#fff;background:#dd475e;padding:10px 15px;border-radius:10px;font-weight:850;cursor:pointer}.logout:hover{background:#c93650}
        .layout{display:flex;min-height:calc(100vh - 70px)}.sidebar{width:255px;flex:0 0 255px;background:linear-gradient(180deg,var(--sidebar),#261c49);color:#fff;padding:17px 12px;position:sticky;top:70px;height:calc(100vh - 70px);overflow-y:auto}.side-title{color:#cfc7ed;font-size:11px;font-weight:900;letter-spacing:1px;text-transform:uppercase;padding:2px 10px 12px}
        .staff-box{display:flex;align-items:center;gap:11px;padding:12px;border-radius:15px;background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.09);margin:0 1px 16px}.avatar{width:43px;height:43px;flex:0 0 43px;border-radius:13px;background:linear-gradient(135deg,#8c6ef5,#5b3fd2);display:grid;place-items:center;font-size:14px;font-weight:900}.staff-name{font-weight:850;font-size:13px;line-height:1.3}.staff-code{margin-top:3px;color:#bbb1df;font-size:11px;font-weight:700}
        .menu{display:flex;flex-direction:column;gap:5px}.menu a{display:flex;align-items:center;gap:10px;text-decoration:none;color:#f5f2ff;padding:11px 12px;border-radius:11px;font-size:13px;font-weight:750;line-height:1.35;transition:background .15s}.menu a:hover{background:rgba(255,255,255,.09)}.menu a.active{background:linear-gradient(90deg,#6948db,#7852ed);box-shadow:0 7px 18px rgba(70,45,170,.27)}.menu-icon{width:23px;flex:0 0 23px;text-align:center;font-size:16px}.soon{margin-left:auto;border-radius:999px;padding:3px 6px;background:rgba(255,255,255,.1);color:#d5cffa;font-size:9px;font-weight:900;text-transform:uppercase}
        .content{flex:1;min-width:0;padding:25px;background:radial-gradient(circle at 100% 0,rgba(105,72,220,.08),transparent 24%),linear-gradient(180deg,#f8f9fc,#f1f4f9)}.page-head{display:flex;align-items:flex-start;justify-content:space-between;gap:18px;margin-bottom:20px}.eyebrow{margin:0 0 5px;color:var(--primary);font-size:12px;font-weight:900;letter-spacing:.9px;text-transform:uppercase}h1{margin:0;font-size:29px;line-height:1.2;letter-spacing:-.5px;font-weight:900;color:#2a3150}.subtitle{margin:8px 0 0;color:var(--muted);font-size:14px;line-height:1.55;font-weight:550}.head-actions{display:flex;align-items:center;gap:9px;flex-wrap:wrap}.pill{background:#fff;border:1px solid #ded8fa;color:var(--primary-dark);padding:10px 13px;border-radius:12px;font-size:12px;font-weight:850;white-space:nowrap;box-shadow:0 6px 17px rgba(31,41,55,.05)}
        .alert{margin-bottom:16px;padding:13px 15px;border-radius:12px;font-size:13px;font-weight:750;line-height:1.5}.alert-success{background:var(--green-light);color:#08754e;border:1px solid #bce8d5}.alert-error{background:var(--red-light);color:#a92e45;border:1px solid #f2c4cc}.alert-error ul{margin:7px 0 0 19px;padding:0}
        .card{background:#fff;border:1px solid var(--border);border-radius:17px;box-shadow:var(--shadow);margin-bottom:18px;overflow:hidden}.card-head{padding:17px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;gap:12px}.card-head h2{margin:0;color:#2a3150;font-size:17px;font-weight:900}.card-head p{margin:5px 0 0;color:var(--muted);font-size:12px;line-height:1.45}.card-body{padding:19px 20px}.detail-table{width:100%;border-collapse:separate;border-spacing:0;min-width:0}.detail-table th,.detail-table td{padding:11px 13px;border-bottom:1px solid #edf0f5;text-align:left;vertical-align:top;line-height:1.5;overflow-wrap:anywhere}.detail-table tr:last-child th,.detail-table tr:last-child td{border-bottom:0}.detail-table th{width:240px;background:#faf9ff;color:#5540a9;font-size:12px;font-weight:850}.detail-table td{color:#303a53;font-size:13px;font-weight:600}.status{display:inline-flex;align-items:center;padding:6px 10px;border-radius:999px;font-size:10px;font-weight:900;text-transform:uppercase;letter-spacing:.3px}.status-approved{background:#e7f8f0;color:#08754e}.status-rejected{background:#fff0f2;color:#aa2942}.status-submitted{background:#fff5df;color:#a36a00}
        .profile-images{display:flex;align-items:flex-start;gap:24px;flex-wrap:wrap}.image-item{display:flex;flex-direction:column;gap:8px;color:#66738a;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:.5px}.student-photo{width:128px;height:150px;object-fit:cover;border:1px solid #e0e4ee;border-radius:12px;background:#f8f9fc}.signature-image{width:220px;height:82px;object-fit:contain;border:1px solid #e0e4ee;border-radius:12px;background:#fff}.not-uploaded{width:128px;min-height:60px;border:1px dashed #d3d9e5;border-radius:12px;display:grid;place-items:center;color:#8892a5;font-size:12px;font-weight:650;text-transform:none;letter-spacing:0;padding:8px}
        .table-wrap{width:100%;overflow-x:auto}.data-table{width:100%;min-width:850px;border-collapse:collapse}.data-table th{padding:12px 13px;text-align:left;background:#f7f8fc;color:#66728a;font-size:10px;font-weight:900;text-transform:uppercase;letter-spacing:.5px;border-bottom:1px solid var(--border);white-space:nowrap}.data-table td{padding:13px;border-bottom:1px solid #edf0f5;vertical-align:top;font-size:12px;font-weight:600;color:#303a53}.data-table tbody tr:hover{background:#fbfaff}.muted{color:var(--muted);font-weight:550}.doc-link{display:inline-flex;align-items:center;justify-content:center;padding:8px 11px;border-radius:9px;background:#f0ecff;color:#4f35ba;text-decoration:none;font-size:11px;font-weight:900}.doc-link:hover{background:#e4dcff}
        .remarks-box{padding:14px 16px;border-radius:12px;background:var(--amber-light);border:1px solid #f0d9a2;color:#805809;font-size:13px;font-weight:650;line-height:1.6}.remarks-meta{margin-top:9px;color:#927021;font-size:11px;font-weight:800}
        .verification-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:14px}.verification-box{border:1px solid var(--border);border-radius:14px;padding:17px;background:#fbfcff}.verification-box h3{margin:0 0 6px;font-size:15px;color:#2a3150;font-weight:900}.verification-box p{margin:0 0 14px;color:var(--muted);font-size:12px;line-height:1.5}.verification-box label{display:block;font-size:12px;font-weight:850;color:#56627a;margin:0 0 7px}.verification-box textarea{width:100%;min-height:100px;resize:vertical;border:1px solid #d8deea;border-radius:10px;padding:11px 12px;font-family:inherit;font-size:13px;color:var(--text);outline:none}.verification-box textarea:focus{border-color:#907aea;box-shadow:0 0 0 4px rgba(105,72,220,.1)}.button-row{display:flex;gap:9px;flex-wrap:wrap;margin-top:13px}.btn{min-height:40px;border:0;border-radius:10px;padding:0 14px;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;font-family:inherit;font-size:11px;font-weight:900;cursor:pointer}.btn-primary{background:linear-gradient(135deg,#714ce4,#5338c8);color:#fff}.btn-green{background:#11976c;color:#fff}.btn-red{background:#d9435b;color:#fff}.btn-light{background:#fff;border:1px solid #dfe4ed;color:#536078}.btn:hover{filter:brightness(.97)}.locked{padding:15px 17px;background:#f1f4f9;border:1px solid #dfe5ef;border-radius:12px;color:#4b5870;font-size:13px;line-height:1.6}.locked strong{display:block;margin-bottom:4px;color:#2a3150;font-size:14px}
        @media(max-width:1100px){.content{padding:18px}.sidebar{width:235px;flex-basis:235px}.verification-grid{grid-template-columns:1fr}.detail-table th{width:190px}}
        @media(max-width:700px){.layout{display:block}.sidebar{position:static;width:100%;height:auto}.content{padding:14px}.topbar{height:auto;min-height:70px;padding:12px 15px;gap:10px;flex-wrap:wrap}.brand{font-size:16px}.top-right{font-size:12px}.page-head{flex-direction:column}h1{font-size:24px}.card-body{padding:14px}.card-head{padding:14px}.detail-table th{width:42%;}.profile-images{gap:14px}}
    </style>
</head>
<body>
@php
    $loggedInUser = auth()->user();
    $staffName = $loggedInUser->name ?? 'Staff';
    $staffProfile = $loggedInUser?->staffProfile;
    $initials = collect(preg_split('/\s+/', trim($staffName)))->filter()->map(fn($part) => strtoupper(substr($part, 0, 1)))->take(2)->implode('');
    $today = now()->toDateString();
    $activePermissionKeys = $staffProfile
        ? $staffProfile->permissions()->where('is_active', true)
            ->where(function ($query) use ($today) { $query->whereNull('start_date')->orWhereDate('start_date', '<=', $today); })
            ->where(function ($query) use ($today) { $query->whereNull('end_date')->orWhereDate('end_date', '>=', $today); })
            ->pluck('permission_key')->flip()
        : collect()->flip();
    $student = $application->student;
    $profile = $student?->studentProfile;
    $qualifications = $profile?->qualifications?->where('is_active', true) ?? collect();
    $documents = $profile?->documents?->where('is_active', true) ?? collect();
    $applicationStatus = strtolower((string) ($application->status ?? 'submitted'));
    $submittedAt = $application->submitted_at ?? $application->created_at;
@endphp
<header class="topbar">
    <div class="brand"><span class="brand-icon">🎓</span><span>College ERP — Unit Teacher Panel</span></div>
    <div class="top-right"><span>{{ $staffName }}</span><form method="POST" action="{{ route('staff.logout') }}">@csrf<button class="logout" type="submit">Logout</button></form></div>
</header>
<div class="layout">
    <aside class="sidebar">
        <div class="side-title">Staff Menu</div>
        <div class="staff-box"><div class="avatar">{{ $initials ?: 'ST' }}</div><div><div class="staff-name">{{ $staffName }}</div><div class="staff-code">{{ $staffProfile?->employee_code ?? 'Unit Teacher' }}</div></div></div>
        <nav class="menu">
            <a href="{{ route('staff.dashboard') }}"><span class="menu-icon">🏠</span><span>Dashboard</span></a>
            @if(isset($activePermissionKeys['new_applicants']))<a class="active" href="{{ route('staff.applications.index') }}"><span class="menu-icon">📝</span><span>New Applicants</span></a>@endif
            @if(isset($activePermissionKeys['registered_applicants']))<a href="{{ route('staff.registered-applicants.index') }}"><span class="menu-icon">🎓</span><span>Registered Applicants</span></a>@endif
            @if(isset($activePermissionKeys['manage_attendance']))<a href="#" onclick="return false"><span class="menu-icon">📊</span><span>Manage Attendance</span></a>@endif
            @if(isset($activePermissionKeys['previous_attendance']))<a href="#" onclick="return false"><span class="menu-icon">📁</span><span>Previous Attendance</span></a>@endif
            @if(isset($activePermissionKeys['readmission']))<a href="#" onclick="return false"><span class="menu-icon">🔄</span><span>Readmission</span></a>@endif
            @if(isset($activePermissionKeys['house_exams']))<a href="#" onclick="return false"><span class="menu-icon">📝</span><span>House Exams</span></a>@endif
            @if(isset($activePermissionKeys['marksheet_management']))<a href="#" onclick="return false"><span class="menu-icon">📄</span><span>Marksheet Management</span></a>@endif
            @if(isset($activePermissionKeys['fee_concession']))<a href="#" onclick="return false"><span class="menu-icon">💳</span><span>Fee Concession</span></a>@endif
            @if(isset($activePermissionKeys['online_fee_verification']))<a href="#" onclick="return false"><span class="menu-icon">💻</span><span>Online Fee Verification</span></a>@endif
            @if(isset($activePermissionKeys['offline_fee_verification']))<a href="{{ route('staff.fee-verification.index') }}"><span class="menu-icon">🧾</span><span>Offline Fee Verification</span></a>@endif
            @if(isset($activePermissionKeys['course_program_change']))<a href="#" onclick="return false"><span class="menu-icon">🔁</span><span>Course / Program Change</span></a>@endif
            @if(isset($activePermissionKeys['university_data']))<a href="#" onclick="return false"><span class="menu-icon">🏛️</span><span>University Data</span></a>@endif
        </nav>
    </aside>

    <main class="content">
        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        @if(session('error'))<div class="alert alert-error">{{ session('error') }}</div>@endif
        @if($errors->any())<div class="alert alert-error"><strong>Please correct the following:</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif

        <div class="page-head">
            <div><p class="eyebrow">Admissions • Step 5 Review</p><h1>Application Verification</h1><p class="subtitle">Review the complete student application before approval or rejection. Student details are displayed for verification.</p></div>
            <div class="head-actions"><span class="pill">📄 {{ $application->application_no ?? 'Application' }}</span><a class="btn btn-light" href="{{ route('staff.applications.index') }}">← Back to Applicants</a></div>
        </div>

        <section class="card">
            <div class="card-head"><div><h2>Application Information</h2><p>Application, programme and submission details.</p></div><span class="status {{ $applicationStatus === 'approved' ? 'status-approved' : ($applicationStatus === 'rejected' ? 'status-rejected' : 'status-submitted') }}">{{ strtoupper(str_replace('_', ' ', $applicationStatus)) }}</span></div>
            <div class="card-body"><table class="detail-table">
                <tr><th>Application No.</th><td>{{ $application->application_no ?? '-' }}</td></tr>
                <tr><th>Registration No.</th><td>{{ $profile?->registration_no ?? '-' }}</td></tr>
                <tr><th>Student Name</th><td>{{ $student?->name ?? '-' }}</td></tr>
                <tr><th>Email</th><td>{{ $student?->email ?? '-' }}</td></tr>
                <tr><th>Mobile</th><td>{{ $student?->phone ?? '-' }}</td></tr>
                <tr><th>Course / Programme</th><td>{{ $application->course?->name ?? '-' }} @if($application->course?->code)<span class="muted">({{ $application->course->code }})</span>@endif</td></tr>
                <tr><th>Academic Session</th><td>{{ $application->session?->name ?? '-' }}</td></tr>
                <tr><th>Semester</th><td>{{ $application->semester?->name ?? 'Yearly Programme / Not Specified' }}</td></tr>
                <tr><th>Submitted On</th><td>{{ $submittedAt ? \Illuminate\Support\Carbon::parse($submittedAt)->format('d M Y, h:i A') : '-' }}</td></tr>
            </table></div>
        </section>

        <section class="card">
            <div class="card-head"><div><h2>Personal Information</h2><p>Student photograph, signature and personal details.</p></div></div>
            <div class="card-body">
                <div class="profile-images">
                    <div class="image-item"><span>Student Photograph</span>@if($profile?->student_photo_path)<a href="{{ asset('storage/' . $profile->student_photo_path) }}" target="_blank" rel="noopener"><img class="student-photo" src="{{ asset('storage/' . $profile->student_photo_path) }}" alt="Student Photograph"></a>@else<div class="not-uploaded">Not uploaded</div>@endif</div>
                    <div class="image-item"><span>Student Signature</span>@if($profile?->signature_path)<a href="{{ asset('storage/' . $profile->signature_path) }}" target="_blank" rel="noopener"><img class="signature-image" src="{{ asset('storage/' . $profile->signature_path) }}" alt="Student Signature"></a>@else<div class="not-uploaded">Not uploaded</div>@endif</div>
                </div>
                <div style="height:16px"></div>
                <table class="detail-table">
                    <tr><th>Aadhaar</th><td>{{ $profile?->aadhaar ?? '-' }}</td></tr>
                    <tr><th>Date of Birth</th><td>{{ $profile?->date_of_birth ? \Illuminate\Support\Carbon::parse($profile->date_of_birth)->format('d-m-Y') : '-' }}</td></tr>
                    <tr><th>Gender</th><td>{{ $profile?->gender ?? '-' }}</td></tr>
                    <tr><th>Blood Group</th><td>{{ $profile?->blood_group ?? '-' }}</td></tr>
                    <tr><th>Marital Status</th><td>{{ $profile?->marital_status ?? '-' }}</td></tr>
                    <tr><th>Category</th><td>{{ $profile?->category ?? '-' }}</td></tr>
                    <tr><th>Subcategory</th><td>{{ $profile?->subcategory ?? '-' }}</td></tr>
                    <tr><th>Religion</th><td>{{ $profile?->religion ?? '-' }}</td></tr>
                    <tr><th>Nationality</th><td>{{ $profile?->nationality ?? '-' }}</td></tr>
                </table>
            </div>
        </section>

        <section class="card">
            <div class="card-head"><div><h2>Parent / Guardian Information</h2><p>Parent and guardian contact details.</p></div></div>
            <div class="card-body"><table class="detail-table">
                <tr><th>Father's Name</th><td>{{ $profile?->father_name ?? '-' }}</td></tr>
                <tr><th>Father's Mobile</th><td>{{ $profile?->father_mobile ?? '-' }}</td></tr>
                <tr><th>Mother's Name</th><td>{{ $profile?->mother_name ?? '-' }}</td></tr>
                <tr><th>Mother's Mobile</th><td>{{ $profile?->mother_mobile ?? '-' }}</td></tr>
            </table></div>
        </section>

        <section class="card">
            <div class="card-head"><div><h2>Address Information</h2><p>Permanent and correspondence addresses supplied by the student.</p></div></div>
            <div class="card-body"><table class="detail-table">
                <tr><th>Permanent Address</th><td>{{ $profile?->permanent_address ?? '-' }}</td></tr>
                <tr><th>Permanent City</th><td>{{ $profile?->permanent_city ?? '-' }}</td></tr>
                <tr><th>Permanent District</th><td>{{ $profile?->permanent_district ?? '-' }}</td></tr>
                <tr><th>Permanent State</th><td>{{ $profile?->permanent_state ?? '-' }}</td></tr>
                <tr><th>Correspondence Address</th><td>{{ $profile?->correspondence_address ?? '-' }}</td></tr>
                <tr><th>Correspondence City</th><td>{{ $profile?->correspondence_city ?? '-' }}</td></tr>
                <tr><th>Correspondence District</th><td>{{ $profile?->correspondence_district ?? '-' }}</td></tr>
                <tr><th>Correspondence State</th><td>{{ $profile?->correspondence_state ?? '-' }}</td></tr>
            </table></div>
        </section>

        <section class="card">
            <div class="card-head"><div><h2>Educational Qualifications</h2><p>Active qualification records submitted by the student.</p></div><span class="pill">{{ $qualifications->count() }} record(s)</span></div>
            <div class="table-wrap"><table class="data-table"><thead><tr><th>Qualification</th><th>Subjects / Stream</th><th>Board / University</th><th>Roll No.</th><th>School / Institute</th><th>Passing Year</th><th>Obtained</th><th>Total</th><th>Percentage</th></tr></thead><tbody>
                @forelse($qualifications as $qualification)
                    <tr><td>{{ $qualification->qualification_name ?? '-' }}</td><td>{{ $qualification->subjects_stream ?? '-' }}</td><td>{{ $qualification->university_board ?? '-' }}</td><td>{{ $qualification->board_roll_no ?? '-' }}</td><td>{{ $qualification->school_institute ?? '-' }}</td><td>{{ $qualification->passing_year ?? '-' }}</td><td>{{ $qualification->obtained_marks ?? '-' }}</td><td>{{ $qualification->total_marks ?? '-' }}</td><td>{{ $qualification->percentage !== null ? $qualification->percentage.'%' : '-' }}</td></tr>
                @empty
                    <tr><td colspan="9" style="text-align:center;padding:25px;color:#7b879a">No qualifications available.</td></tr>
                @endforelse
            </tbody></table></div>
        </section>

        <section class="card">
            <div class="card-head"><div><h2>Uploaded Documents</h2><p>Open a document in a new browser tab to review it.</p></div><span class="pill">{{ $documents->count() }} document(s)</span></div>
            <div class="table-wrap"><table class="data-table" style="min-width:480px"><thead><tr><th>Document Name</th><th>File</th><th>Action</th></tr></thead><tbody>
                @forelse($documents as $document)
                    <tr><td>{{ $document->document_name ?? 'Document' }}</td><td class="muted">{{ basename((string) $document->file_path) }}</td><td><a class="doc-link" href="{{ asset('storage/' . $document->file_path) }}" target="_blank" rel="noopener">View Document ↗</a></td></tr>
                @empty
                    <tr><td colspan="3" style="text-align:center;padding:25px;color:#7b879a">No active documents uploaded.</td></tr>
                @endforelse
            </tbody></table></div>
        </section>

        @if($application->review_remarks)
            <section class="card"><div class="card-head"><div><h2>Teacher Remarks</h2><p>Previous review history for this application.</p></div></div><div class="card-body"><div class="remarks-box">{{ $application->review_remarks }}@if($application->reviewed_at)<div class="remarks-meta">Reviewed on {{ \Illuminate\Support\Carbon::parse($application->reviewed_at)->format('d M Y, h:i A') }}</div>@endif</div></div></section>
        @endif

        <section class="card">
            <div class="card-head"><div><h2>Verification Decision</h2><p>Approve the application or reject it with a clear reason. Approved applications are locked for student editing.</p></div></div>
            <div class="card-body">
                @if($applicationStatus === 'submitted')
                    <div class="verification-grid">
                        <div class="verification-box"><h3>Approve Application</h3><p>Confirm the information and approve this application for the next admission stage.</p><form method="POST" action="{{ route('staff.applications.approve', $application->id) }}">@csrf<label for="approve_remarks">Approval Remarks (optional)</label><textarea name="remarks" id="approve_remarks" placeholder="Enter approval remarks (optional)">{{ old('approve_remarks') }}</textarea><div class="button-row"><button class="btn btn-green" type="submit" onclick="return confirm('Are you sure you want to approve this application?')">✓ Approve Application</button></div></form></div>
                        <div class="verification-box"><h3>Reject Application</h3><p>Enter a mandatory reason. The student will be allowed to edit and resubmit the application.</p><form method="POST" action="{{ route('staff.applications.reject', $application->id) }}">@csrf<label for="reject_remarks">Rejection Reason <span style="color:#d9435b">*</span></label><textarea name="remarks" id="reject_remarks" placeholder="Explain why this application is being rejected" required>{{ old('remarks') }}</textarea><div class="button-row"><button class="btn btn-red" type="submit" onclick="return confirm('Reject this application and allow the student to edit and resubmit?')">✕ Reject Application</button></div></form></div>
                    </div>
                @elseif($applicationStatus === 'approved')
                    <div class="locked"><strong>✓ Application Approved</strong>This application has already been approved. No further verification action is available.</div>
                @elseif($applicationStatus === 'rejected')
                    <div class="locked"><strong>Application Rejected</strong>The rejection reason is shown in Teacher Remarks. The student can edit and resubmit the application.</div>
                @else
                    <div class="locked"><strong>Application Status: {{ strtoupper($applicationStatus) }}</strong>No verification action is available for this status.</div>
                @endif
                <div class="button-row"><a class="btn btn-light" href="{{ route('staff.applications.index') }}">← Back to New Applicants</a></div>
            </div>
        </section>
    </main>
</div>
</body>
</html>
