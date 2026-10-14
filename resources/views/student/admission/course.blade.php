<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Course - College ERP</title>
    <style>
        :root{--purple:#43358f;--purple2:#5142a8;--ink:#20243a;--muted:#687087;--line:#e5e7ef;--bg:#f4f6fb;--green:#198754}
        *{box-sizing:border-box}body{margin:0;font-family:Arial,Helvetica,sans-serif;background:var(--bg);color:var(--ink);font-size:14px}
        .topbar{height:62px;background:var(--purple);color:#fff;display:flex;align-items:center;justify-content:space-between;padding:0 24px;font-weight:700;box-shadow:0 3px 12px #1b16421c}
        .brand{display:flex;align-items:center;gap:10px}.brand-icon{width:34px;height:34px;border-radius:50%;background:#ffffff24;display:grid;place-items:center;font-size:19px}.user-name{font-weight:600;font-size:13px}
        .shell{display:flex;min-height:calc(100vh - 62px)}.sidebar{width:225px;flex:0 0 225px;background:#fff;border-right:1px solid #e4e6ed;padding:18px 0}.college-mark{height:88px;display:flex;align-items:center;justify-content:center;flex-direction:column;gap:8px;border-bottom:1px solid var(--line);margin-bottom:12px}.logo{height:48px;width:48px;border-radius:50%;display:grid;place-items:center;border:2px solid #eceafa;color:var(--purple);font-weight:800;font-size:11px}.mark-caption{font-size:11px;color:var(--muted)}
        .nav-link{display:flex;align-items:center;gap:10px;margin:3px 10px;padding:12px 13px;color:#34384a;text-decoration:none;border-radius:7px;font-size:12px;font-weight:600}.nav-link:hover{background:#f4f1ff}.nav-link.active{background:#eeeaff;color:var(--purple);border-left:3px solid var(--purple);padding-left:10px}.nav-icon{width:17px;text-align:center}
        .main{flex:1;min-width:0;padding:30px 34px 44px}.page-heading{margin:0 0 7px;font-size:24px;font-weight:800;letter-spacing:.2px}.page-subtitle{margin:0 0 23px;color:var(--muted);font-size:13px}.steps{display:flex;gap:8px;margin-bottom:22px;flex-wrap:wrap}.step{background:#fff;border:1px solid var(--line);border-radius:20px;padding:9px 14px;color:#777d91;font-size:11px;font-weight:700}.step.current{background:#eeeaff;border-color:#d7d0ff;color:var(--purple)}.step.done{color:#198754}
        .card{max-width:1000px;background:#fff;border:1px solid #e6e8f0;border-radius:10px;box-shadow:0 8px 24px #22294a0b;overflow:hidden}.card-header{background:var(--purple);color:#fff;padding:15px 20px;font-size:14px;font-weight:700}.card-body{padding:24px}.notice{border-radius:8px;padding:12px 14px;margin-bottom:20px;font-size:12px;line-height:1.5}.notice.info{background:#f0eeff;border:1px solid #e1dcff;color:#43358f}.notice.success{background:#ecfdf3;border:1px solid #c8f0d8;color:#176b3a}.notice.error{background:#fff1f2;border:1px solid #fecdd3;color:#a61b34}.error-list{margin:6px 0 0;padding-left:18px}
        .form-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:21px 24px}.field{min-width:0}.field label{display:block;margin-bottom:8px;font-size:12px;font-weight:700;color:#34384b}.required{color:#d12c46}.field select,.field input{display:block;width:100%;height:43px;padding:0 12px;border:1px solid #d9dce6;border-radius:6px;background:#fff;color:#282c3e;font-size:13px;outline:none}.field select:focus,.field input:focus{border-color:#8173d8;box-shadow:0 0 0 3px #5142a815}.field select:disabled,.field input:disabled{background:#f4f5f8;color:#74798a}.field small{display:block;color:#7b8193;font-size:11px;line-height:1.5;margin-top:7px}.field.full{grid-column:1/-1}.session-field input{background:#f8f7ff;font-weight:700;color:var(--purple)}.form-note{background:#f8f9fc;border:1px solid #e9ebf2;border-radius:7px;padding:13px 15px;margin-top:22px;color:#60677c;font-size:12px;line-height:1.6}.actions{display:flex;justify-content:space-between;align-items:center;gap:12px;margin-top:25px;padding-top:20px;border-top:1px solid #eceef4}.btn{display:inline-flex;align-items:center;justify-content:center;min-height:40px;border:0;border-radius:6px;padding:0 20px;text-decoration:none;font-size:12px;font-weight:700;cursor:pointer}.btn-back{background:#747b88;color:#fff}.btn-primary{background:var(--green);color:#fff}.btn-primary:hover{background:#157347}.btn:disabled{opacity:.6;cursor:not-allowed}.lock-text{font-size:12px;color:var(--muted)}
        @media(max-width:850px){.sidebar{width:190px;flex-basis:190px}.main{padding:24px 20px}}@media(max-width:650px){.shell{display:block}.sidebar{width:100%;padding:8px 0;border-right:0;border-bottom:1px solid var(--line)}.college-mark{height:65px}.sidebar nav{display:flex;overflow-x:auto;padding:0 5px}.nav-link{white-space:nowrap;margin:2px;padding:10px}.main{padding:22px 14px}.form-grid{grid-template-columns:1fr}.field.full{grid-column:auto}.card-body{padding:18px}.page-heading{font-size:21px}.topbar{padding:0 14px}}
    </style>
</head>
<body>
<header class="topbar">
    <div class="brand"><div class="brand-icon">🎓</div><span>Student Panel</span></div>
    <div class="user-name">{{ auth()->user()->name ?? 'Student' }}</div>
</header>
<div class="shell">
    <aside class="sidebar">
        <div class="college-mark"><div class="logo">COLLEGE</div><div class="mark-caption">Student Portal</div></div>
        <nav>
            <a class="nav-link" href="{{ Route::has('student.dashboard') ? route('student.dashboard') : url('/student/dashboard') }}"><span class="nav-icon">🏠</span>Dashboard</a>
            <a class="nav-link active" href="{{ route('student.admission.course') }}"><span class="nav-icon">📚</span>Course / Programme</a>
            <a class="nav-link" href="{{ route('student.personal') }}"><span class="nav-icon">👤</span>Personal Information</a>
            <a class="nav-link" href="{{ route('student.qualifications') }}"><span class="nav-icon">🎓</span>Education Qualification</a>
            <a class="nav-link" href="{{ route('student.documents') }}"><span class="nav-icon">📄</span>Document Upload</a>
            <a class="nav-link" href="{{ route('student.registration.form') }}"><span class="nav-icon">📝</span>Registration Form</a>
            <form method="POST" action="{{ route('logout') }}" style="margin:0">@csrf<button type="submit" class="nav-link" style="width:calc(100% - 20px);border:0;background:transparent;text-align:left;cursor:pointer"><span class="nav-icon">🔒</span>Sign Out</button></form>
        </nav>
    </aside>
    <main class="main">
        <h1 class="page-heading">STEP 1: CHOOSE COURSE</h1>
        <p class="page-subtitle">Select your admission type, department and programme to continue your admission application.</p>
        <div class="steps"><div class="step current">1. Course / Programme</div><div class="step">2. Personal Information</div><div class="step">3. Education Qualification</div><div class="step">4. Document Upload</div><div class="step">5. Registration Form</div></div>
        <section class="card">
            <div class="card-header">Admission Details</div>
            <div class="card-body">
                @if(session('success'))<div class="notice success">{{ session('success') }}</div>@endif
                @if($errors->any())<div class="notice error"><strong>Please correct the following:</strong><ul class="error-list">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
                @if($isLocked)<div class="notice info">Your application is <strong>{{ ucfirst($application->status) }}</strong>. Admission details are read-only.</div>@endif
                <form method="POST" action="{{ url('/student/admission/course') }}">
                    @csrf
                    @php
                        $chosenType = old('admission_type', $application->admission_type ?? 'new');
                        $chosenDept = old('department_id', $selectedDepartmentId ?? null);
                        $chosenCourse = old('course_id', $application->course_id ?? null);
                        $chosenSemester = old('semester_id', $application->semester_id ?? null);
                    @endphp
                    <div class="form-grid">
                        <div class="field">
                            <label for="admission_type">Admission Type <span class="required">*</span></label>
                            <select name="admission_type" id="admission_type" required @disabled($isLocked)>
                                <option value="new" @selected($chosenType === 'new')>New</option>
                                <option value="old" @selected($chosenType === 'old')>Old</option>
                            </select>
                            <small>Choose New for first-time admission or Old for a continuing student.</small>
                        </div>
                        <div class="field session-field">
                            <label for="academic_session_display">Academic Session</label>
                            <input id="academic_session_display" value="{{ $activeSession->name ?? 'Not configured' }}" readonly>
                            <small>Automatically selected by the college administration.</small>
                        </div>
                        <div class="field">
                            <label for="department_id">Department <span class="required">*</span></label>
                            <select name="department_id" id="department_id" required @disabled($isLocked)>
                                <option value="">Select Department</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}" @selected((string)$chosenDept === (string)$department->id)>{{ $department->name }}</option>
                                @endforeach
                            </select>
                            <small>First select the department, then select a programme offered under it.</small>
                        </div>
                        <div class="field">
                            <label for="course_id">Course / Programme <span class="required">*</span></label>
                            <select name="course_id" id="course_id" required @disabled($isLocked)>
                                <option value="">Select Course / Programme</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" data-department="{{ $course->department_id }}" @selected((string)$chosenCourse === (string)$course->id)>{{ $course->name }}{{ $course->code ? ' ('.$course->code.')' : '' }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="field" id="semester_wrapper">
                            <label for="semester_id">Current Semester <span class="required" id="semester_required">*</span></label>
                            <select name="semester_id" id="semester_id" @disabled($isLocked)>
                                <option value="">Select Semester</option>
                                @foreach($semesters as $semester)
                                    <option value="{{ $semester->id }}" data-number="{{ $semester->semester_number }}" @selected((string)$chosenSemester === (string)$semester->id)>{{ $semester->name }}{{ isset($semester->semester_number) ? ' (Semester '.$semester->semester_number.')' : '' }}</option>
                                @endforeach
                            </select>
                            <small id="semester_help">New admissions are automatically placed in Semester 1.</small>
                        </div>
                    </div>
                    <div class="form-note"><strong>Important:</strong> Department and course offerings are managed by College Administration. New admissions are assigned Semester 1 automatically. Old admissions must select their current semester.</div>
                    <div class="actions">
                        <a class="btn btn-back" href="{{ Route::has('student.dashboard') ? route('student.dashboard') : url('/student/dashboard') }}">Back</a>
                        @if(!$isLocked)
                            <button class="btn btn-primary" type="submit">SAVE &amp; NEXT&nbsp; →</button>
                        @else
                            <span class="lock-text">🔒 Editing is disabled after submission.</span>
                        @endif
                    </div>
                </form>
            </div>
        </section>
    </main>
</div>
@if(!$isLocked)
<script>
document.addEventListener('DOMContentLoaded', function () {
    const type = document.getElementById('admission_type');
    const department = document.getElementById('department_id');
    const course = document.getElementById('course_id');
    const semester = document.getElementById('semester_id');
    const semesterWrap = document.getElementById('semester_wrapper');
    const semesterHelp = document.getElementById('semester_help');
    const semesterRequired = document.getElementById('semester_required');

    function filterCourses(resetInvalid) {
        let selectedStillValid = false;
        [...course.options].forEach(function (option) {
            if (!option.value) return;
            const visible = option.dataset.department === department.value;
            option.hidden = !visible;
            option.disabled = !visible;
            if (visible && option.selected) selectedStillValid = true;
        });
        if (resetInvalid && course.value && !selectedStillValid) course.value = '';
    }

    function updateAdmissionType() {
        const isOld = type.value === 'old';
        semesterWrap.style.display = isOld ? '' : 'none';
        semester.required = isOld;
        semester.disabled = !isOld;
        semesterRequired.style.display = isOld ? 'inline' : 'none';
        semesterHelp.textContent = isOld
            ? 'Select the current semester for this continuing student.'
            : 'Semester 1 will be assigned automatically when you save.';
        if (!isOld) semester.value = '';
    }

    department.addEventListener('change', function () { filterCourses(true); });
    type.addEventListener('change', updateAdmissionType);
    filterCourses(false);
    updateAdmissionType();
});
</script>
@endif
</body>
</html>
