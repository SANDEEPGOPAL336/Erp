@extends('admin.layouts.app')

@section('title', 'Department & Course Assignment - College ERP')

@section('content')
<style>
    .asa-page{padding:24px;background:#f5f6fa;min-height:calc(100vh - 70px);color:#202637}
    .asa-head{display:flex;justify-content:space-between;align-items:flex-start;gap:18px;margin-bottom:18px}
    .asa-head h1{margin:0;font-size:25px;font-weight:850;letter-spacing:-.25px}
    .asa-head p{margin:7px 0 0;color:#6f7a8d;font-size:13px;line-height:1.55;max-width:780px}
    .asa-pill{padding:10px 13px;border-radius:12px;background:#eeeaff;color:#4f3ab9;border:1px solid #ded6ff;font-size:12px;font-weight:800;white-space:nowrap}
    .asa-alert{padding:12px 15px;border-radius:12px;margin-bottom:14px;font-size:13px;font-weight:650}
    .asa-success{background:#e7f8ef;border:1px solid #b9e9ce;color:#12633c}
    .asa-error{background:#fff0f0;border:1px solid #f1c4c4;color:#9f2626}
    .asa-layout{display:grid;grid-template-columns:minmax(330px,.85fr) minmax(520px,1.5fr);gap:18px;align-items:start}
    .asa-card{background:#fff;border:1px solid #e2e6ef;border-radius:17px;box-shadow:0 8px 24px rgba(31,41,55,.06);overflow:hidden;min-width:0}
    .asa-card-head{padding:17px 19px;border-bottom:1px solid #e9ecf2;background:linear-gradient(90deg,#fff,#faf9ff)}
    .asa-card-head h2{margin:0;font-size:17px;font-weight:850}
    .asa-card-head p{margin:5px 0 0;color:#748095;font-size:12px;line-height:1.45}
    .asa-card-body{padding:18px}
    .asa-form-grid{display:grid;grid-template-columns:1fr 1fr;gap:13px}
    .asa-field{min-width:0}
    .asa-field.full{grid-column:1/-1}
    .asa-field label{display:block;margin-bottom:6px;color:#465168;font-size:12px;font-weight:800}
    .asa-field select{width:100%;min-height:43px;padding:10px 11px;border:1px solid #d8deea;border-radius:10px;background:#fff;color:#283349;font:600 13px 'Segoe UI',Arial,sans-serif;outline:none}
    .asa-field select:focus{border-color:#7f6ce4;box-shadow:0 0 0 3px rgba(104,71,232,.12)}
    .asa-help{margin-top:5px;font-size:11px;line-height:1.4;color:#798499}
    .asa-btn{border:0;border-radius:10px;min-height:43px;padding:0 16px;font-size:12px;font-weight:850;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;justify-content:center}
    .asa-btn-primary{background:linear-gradient(135deg,#6548dc,#4932b9);color:#fff;box-shadow:0 6px 14px rgba(82,56,195,.18)}
    .asa-btn-danger{background:#fff1f1;color:#b42334;border:1px solid #f4c9ce;min-height:33px;padding:0 10px}
    .asa-form-actions{margin-top:17px;display:flex;justify-content:flex-end}
    .asa-note{margin-top:14px;padding:12px 13px;border-radius:11px;background:#fff8e8;border:1px solid #f4dfaa;color:#7b5508;font-size:12px;line-height:1.55}
    .asa-table-wrap{overflow-x:auto}
    .asa-table{width:100%;border-collapse:collapse;min-width:760px}
    .asa-table th{padding:12px 13px;background:#f7f8fc;border-bottom:1px solid #e6e9f0;text-align:left;color:#657087;font-size:10px;font-weight:900;letter-spacing:.45px;text-transform:uppercase;white-space:nowrap}
    .asa-table td{padding:12px 13px;border-bottom:1px solid #eef0f5;font-size:12px;color:#293349;vertical-align:middle}
    .asa-table tr:hover td{background:#fcfbff}
    .asa-staff-name{font-weight:850;color:#202b42}
    .asa-muted{margin-top:3px;color:#7b8699;font-size:11px}
    .asa-chip{display:inline-flex;align-items:center;padding:5px 8px;border-radius:999px;background:#eeeaff;color:#5340bf;font-size:10px;font-weight:850;white-space:nowrap}
    .asa-active{background:#e5f8ee;color:#137344}
    .asa-inactive{background:#fff0f1;color:#b42334}
    .asa-empty{text-align:center;padding:34px 16px;color:#69758a;font-size:13px}
    .asa-pagination{padding:14px 17px;border-top:1px solid #edf0f5}
    .asa-pagination nav{display:flex;justify-content:flex-end}
    .asa-pagination svg{height:18px;width:18px}
    @media(max-width:1120px){.asa-layout{grid-template-columns:1fr}.asa-table{min-width:800px}}
    @media(max-width:640px){.asa-page{padding:14px}.asa-head{flex-direction:column}.asa-head h1{font-size:22px}.asa-form-grid{grid-template-columns:1fr}.asa-field.full{grid-column:auto}.asa-card-body{padding:14px}}
</style>

<div class="asa-page">
    <div class="asa-head">
        <div>
            <h1>Department & Course Assignment</h1>
            <p>Assign each Unit Teacher to a department, sub-department, course/programme, academic session and optionally a semester. These academic assignments determine which student applications appear in the teacher's panels.</p>
        </div>
        <div class="asa-pill">🎯 Staff Academic Assignments</div>
    </div>

    @if(session('success'))
        <div class="asa-alert asa-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="asa-alert asa-error">
            <strong>Please correct the following:</strong>
            <ul style="margin:7px 0 0 18px;padding:0;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="asa-layout">
        <section class="asa-card">
            <div class="asa-card-head">
                <h2>Assign Staff Member</h2>
                <p>Add one course/session assignment at a time. Repeat to give the same staff member more courses.</p>
            </div>
            <div class="asa-card-body">
                <form method="POST" action="{{ route('admin.staff.assignments.store') }}">
                    @csrf
                    <div class="asa-form-grid">
                        <div class="asa-field full">
                            <label for="staff_profile_id">Staff Member *</label>
                            <select id="staff_profile_id" name="staff_profile_id" required>
                                <option value="">Select staff member</option>
                                @foreach($staffProfiles as $profile)
                                    <option value="{{ $profile->id }}" {{ (string)old('staff_profile_id') === (string)$profile->id ? 'selected' : '' }}>
                                        {{ $profile->user?->name ?? 'Staff' }} — {{ $profile->employee_code ?? 'No employee code' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="asa-field">
                            <label for="department_id">Department *</label>
                            <select id="department_id" name="department_id" required>
                                <option value="">Select department</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}" {{ (string)old('department_id') === (string)$department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="asa-field">
                            <label for="sub_department_id">Sub-Department *</label>
                            <select id="sub_department_id" name="sub_department_id" required>
                                <option value="">Select sub-department</option>
                                @foreach($subDepartments as $subDepartment)
                                    <option value="{{ $subDepartment->id }}" data-department="{{ $subDepartment->department_id }}" {{ (string)old('sub_department_id') === (string)$subDepartment->id ? 'selected' : '' }}>{{ $subDepartment->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="asa-field full">
                            <label for="course_id">Course / Programme *</label>
                            <select id="course_id" name="course_id" required>
                                <option value="">Select course/programme</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" data-sub-department="{{ $course->sub_department_id }}" {{ (string)old('course_id') === (string)$course->id ? 'selected' : '' }}>
                                        {{ $course->code }} — {{ $course->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="asa-help">Course options are filtered to the selected sub-department.</div>
                        </div>

                        <div class="asa-field full">
                            <label for="academic_session_id">Academic Session *</label>
                            <select id="academic_session_id" name="academic_session_id" required>
                                <option value="">Select academic session</option>
                                @foreach($sessions as $session)
                                    <option value="{{ $session->id }}" {{ (string)old('academic_session_id') === (string)$session->id ? 'selected' : '' }}>{{ $session->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="asa-field full">
                            <label for="semester_id">Semester (optional)</label>
                            <select id="semester_id" name="semester_id">
                                <option value="">All semesters / complete course</option>
                                @foreach($semesters as $semester)
                                    <option value="{{ $semester->id }}" {{ (string)old('semester_id') === (string)$semester->id ? 'selected' : '' }}>
                                        {{ $semester->name }}{{ isset($semester->semester_number) ? ' ('.$semester->semester_number.')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="asa-help">Leave blank when the teacher should handle all semesters for that course and session.</div>
                        </div>
                    </div>

                    <div class="asa-form-actions">
                        <button class="asa-btn asa-btn-primary" type="submit">Save Assignment</button>
                    </div>
                </form>

                <div class="asa-note">
                    <strong>Important:</strong> this page assigns academic responsibility. The separate <strong>Role Assignment</strong> item opens module permissions. To see New Applicants, the teacher needs both an active course/session assignment here and the <strong>New Applicants</strong> permission enabled in Staff Permissions.
                </div>
            </div>
        </section>

        <section class="asa-card">
            <div class="asa-card-head">
                <h2>Assigned Staff — Role Assigned Record</h2>
                <p>{{ $assignments->total() }} assignment record(s). Inactive records are retained for audit history.</p>
            </div>

            @if($assignments->count())
                <div class="asa-table-wrap">
                    <table class="asa-table">
                        <thead>
                            <tr>
                                <th>Staff Member</th>
                                <th>Department</th>
                                <th>Course / Programme</th>
                                <th>Session</th>
                                <th>Semester</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($assignments as $assignment)
                                @php
                                    $profile = $assignment->staffProfile;
                                    $course = $assignment->course;
                                    $courseSubDepartmentId = $course?->sub_department_id;
                                    $assignmentDepartmentId = $subDepartmentDepartmentIds[$courseSubDepartmentId ?? 0] ?? 0;
                                    $departmentLabel = $departmentNames[$assignmentDepartmentId] ?? '-';
                                    $subDepartmentLabel = $subDepartmentNames[$courseSubDepartmentId ?? 0] ?? '-';
                                @endphp
                                <tr>
                                    <td>
                                        <div class="asa-staff-name">{{ $profile?->user?->name ?? '-' }}</div>
                                        <div class="asa-muted">{{ $profile?->employee_code ?? '-' }}</div>
                                    </td>
                                    <td>
                                        <div>{{ $departmentLabel }}</div>
                                        <div class="asa-muted">{{ $subDepartmentLabel }}</div>
                                    </td>
                                    <td>
                                        <div class="asa-staff-name">{{ $course?->code ?? '-' }}</div>
                                        <div class="asa-muted">{{ $course?->name ?? '-' }}</div>
                                    </td>
                                    <td>{{ $assignment->session?->name ?? '-' }}</td>
                                    <td>{{ $assignment->semester?->name ?? 'All Semesters' }}</td>
                                    <td>
                                        <span class="asa-chip {{ $assignment->is_active ? 'asa-active' : 'asa-inactive' }}">
                                            {{ $assignment->is_active ? 'ACTIVE' : 'INACTIVE' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($assignment->is_active)
                                            <form method="POST" action="{{ route('admin.staff.assignments.destroy', $assignment) }}" onsubmit="return confirm('Deactivate this staff assignment? The record will be kept for history.');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="asa-btn asa-btn-danger" type="submit">Deactivate</button>
                                            </form>
                                        @else
                                            <span class="asa-muted">No action</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="asa-pagination">{{ $assignments->links() }}</div>
            @else
                <div class="asa-empty">
                    No academic assignments have been created yet.<br>
                    <span class="asa-muted">Add a staff, course, and academic session using the form.</span>
                </div>
            @endif
        </section>
    </div>
</div>

<script>
(function () {
    const department = document.getElementById('department_id');
    const subDepartment = document.getElementById('sub_department_id');
    const course = document.getElementById('course_id');

    function filterSubDepartments() {
        const departmentId = department.value;
        let selectedIsValid = false;

        Array.from(subDepartment.options).forEach(function (option) {
            if (!option.value) {
                option.hidden = false;
                option.disabled = false;
                return;
            }

            const visible = Boolean(departmentId) && option.dataset.department === departmentId;
            option.hidden = !visible;
            option.disabled = !visible;
            if (visible && option.selected) selectedIsValid = true;
        });

        if (!selectedIsValid) subDepartment.value = '';
        filterCourses();
    }

    function filterCourses() {
        const subDepartmentId = subDepartment.value;
        let selectedIsValid = false;

        Array.from(course.options).forEach(function (option) {
            if (!option.value) {
                option.hidden = false;
                option.disabled = false;
                return;
            }

            const visible = Boolean(subDepartmentId) && option.dataset.subDepartment === subDepartmentId;
            option.hidden = !visible;
            option.disabled = !visible;
            if (visible && option.selected) selectedIsValid = true;
        });

        if (!selectedIsValid) course.value = '';
    }

    department.addEventListener('change', filterSubDepartments);
    subDepartment.addEventListener('change', filterCourses);
    filterSubDepartments();
})();
</script>
@endsection
