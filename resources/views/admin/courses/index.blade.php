@extends('admin.layouts.app')

@section('title', 'Course / Programme Management - College ERP')

@section('content')

<div class="admin-page-head">

    <div>

        <h1>📚 Course / Programme Management</h1>

        <p>
            Manage courses, programmes, departments, fees and availability.
        </p>

    </div>


    <a
        href="{{ route('admin.courses.create') }}"
        class="admin-btn admin-btn-primary"
    >
        ➕ Add Course / Programme
    </a>

</div>


<div class="admin-page-line"></div>


{{-- =========================================================
     SUCCESS MESSAGE
========================================================= --}}

@if(session('success'))

    <div class="admin-alert admin-alert-success">

        <strong>
            Success:
        </strong>

        {{ session('success') }}

    </div>

@endif


{{-- =========================================================
     ERROR MESSAGE
========================================================= --}}

@if($errors->any())

    <div class="admin-alert admin-alert-danger">

        <strong>
            Please correct the following:
        </strong>

        @foreach($errors->all() as $error)

            <div>
                {{ $error }}
            </div>

        @endforeach

    </div>

@endif


{{-- =========================================================
     SUMMARY CARDS
========================================================= --}}

@php

    $totalCourses = $courses->count();

    $activeCourses = $courses
        ->where('is_active', true)
        ->count();

    $inactiveCourses = $courses
        ->where('is_active', false)
        ->count();

    $assignedCourses = $courses
        ->whereNotNull('department_id')
        ->count();

    $unassignedCourses = $courses
        ->whereNull('department_id')
        ->count();

@endphp


<div class="course-summary-grid">


    <div class="course-summary-card">

        <div class="summary-icon purple">
            📚
        </div>

        <div>

            <div class="summary-label">
                Total Courses
            </div>

            <div class="summary-number">
                {{ $totalCourses }}
            </div>

        </div>

    </div>


    <div class="course-summary-card">

        <div class="summary-icon green">
            ✓
        </div>

        <div>

            <div class="summary-label">
                Active Courses
            </div>

            <div class="summary-number">
                {{ $activeCourses }}
            </div>

        </div>

    </div>


    <div class="course-summary-card">

        <div class="summary-icon red">
            ⏸
        </div>

        <div>

            <div class="summary-label">
                Inactive Courses
            </div>

            <div class="summary-number">
                {{ $inactiveCourses }}
            </div>

        </div>

    </div>


    <div class="course-summary-card">

        <div class="summary-icon blue">
            🏢
        </div>

        <div>

            <div class="summary-label">
                Department Assigned
            </div>

            <div class="summary-number">
                {{ $assignedCourses }}
            </div>

        </div>

    </div>


</div>


{{-- =========================================================
     COURSE TABLE
========================================================= --}}

<div class="admin-panel">


    <div class="admin-panel-header">

        <div>

            <div class="admin-panel-title">
                Course / Programme List
            </div>

            <div class="admin-panel-subtitle">
                All courses currently configured in the College ERP.
            </div>

        </div>

    </div>


    @if($courses->count() > 0)


        <div class="table-wrapper">

            <table class="admin-table">

                <thead>

                    <tr>

                        <th>
                            #
                        </th>

                        <th>
                            Course / Programme
                        </th>

                        <th>
                            Code
                        </th>

                        <th>
                            Department
                        </th>

                        <th>
                            Duration
                        </th>

                        <th>
                            Admission Fee
                        </th>

                        <th>
                            Annual Fee
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @foreach($courses as $course)

                        <tr>


                            {{-- NUMBER --}}

                            <td>
                                {{ $loop->iteration }}
                            </td>


                            {{-- COURSE NAME --}}

                            <td>

                                <div class="course-name">
                                    {{ $course->name }}
                                </div>

                                @if($course->department)

                                    <div class="course-subtext">

                                        {{ $course->department->name }}

                                    </div>

                                @endif

                            </td>


                            {{-- CODE --}}

                            <td>

                                <span class="code-badge">

                                    {{ $course->code }}

                                </span>

                            </td>


                            {{-- DEPARTMENT --}}

                            <td>

                                @if($course->department)

                                    <span class="department-badge">

                                        {{ $course->department->name }}

                                    </span>

                                @else

                                    <span class="not-assigned">

                                        Not Assigned

                                    </span>

                                @endif

                            </td>


                            {{-- DURATION --}}

                            <td>

                                {{ $course->duration ?: '-' }}

                            </td>


                            {{-- ADMISSION FEE --}}

                            <td>

                                ₹ {{ number_format((float) $course->admission_fee, 2) }}

                            </td>


                            {{-- ANNUAL FEE --}}

                            <td>

                                ₹ {{ number_format((float) $course->annual_fee, 2) }}

                            </td>


                            {{-- STATUS --}}

                            <td>

                                @if($course->is_active)

                                    <span class="status-badge status-active">
                                        Active
                                    </span>

                                @else

                                    <span class="status-badge status-inactive">
                                        Inactive
                                    </span>

                                @endif

                            </td>


                            {{-- ACTIONS --}}

                            <td>

                                <div class="action-row">


                                    {{-- EDIT --}}

                                    <a
                                        href="{{ route('admin.courses.edit', $course) }}"
                                        class="action-btn action-edit"
                                    >
                                        ✏️ Edit
                                    </a>


                                    {{-- TOGGLE --}}

                                    <form
                                        action="{{ route('admin.courses.toggle', $course) }}"
                                        method="POST"
                                        style="display:inline;"
                                    >

                                        @csrf

                                        @method('PATCH')


                                        <button
                                            type="submit"
                                            class="action-btn {{ $course->is_active ? 'action-disable' : 'action-enable' }}"
                                            onclick="return confirm(
                                                '{{ $course->is_active
                                                    ? 'Deactivate this course / programme?'
                                                    : 'Activate this course / programme?' }}'
                                            )"
                                        >

                                            @if($course->is_active)

                                                ⏸ Deactivate

                                            @else

                                                ▶ Activate

                                            @endif

                                        </button>

                                    </form>


                                </div>

                            </td>


                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>


    @else


        <div class="empty-state">

            <div class="empty-icon">
                📚
            </div>

            <h3>
                No Courses Found
            </h3>

            <p>
                No course or programme has been added yet.
            </p>

            <a
                href="{{ route('admin.courses.create') }}"
                class="admin-btn admin-btn-primary"
            >
                ➕ Add First Course
            </a>

        </div>


    @endif


</div>


{{-- =========================================================
     INFORMATION BOX
========================================================= --}}

<div class="admin-info-box">

    <strong>
        Department-Based Course Management
    </strong>

    <p>
        Each course should be assigned to its correct department.
    </p>

    <p>
        Only active courses will be available for student admission.
    </p>

    <p>
        Courses without a department are shown as
        <strong>Not Assigned</strong> and should be mapped before
        students begin selecting them.
    </p>

</div>


{{-- =========================================================
     PAGE STYLES
========================================================= --}}

<style>

.course-summary-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 16px;
    margin-bottom: 22px;
}

.course-summary-card {
    background: #ffffff;
    border: 1px solid #e7e4ef;
    border-radius: 10px;
    padding: 18px;
    display: flex;
    align-items: center;
    gap: 14px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}

.summary-icon {
    width: 46px;
    height: 46px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 21px;
    font-weight: bold;
}

.summary-icon.purple {
    background: #eee7fb;
    color: #6f42c1;
}

.summary-icon.green {
    background: #e2f4ea;
    color: #198754;
}

.summary-icon.red {
    background: #fbe5e8;
    color: #dc3545;
}

.summary-icon.blue {
    background: #e3efff;
    color: #0d6efd;
}

.summary-label {
    font-size: 12px;
    color: #777;
    margin-bottom: 5px;
}

.summary-number {
    font-size: 22px;
    font-weight: 700;
    color: #333;
}

.table-wrapper {
    width: 100%;
    overflow-x: auto;
}

.admin-table {
    width: 100%;
    min-width: 1050px;
    border-collapse: collapse;
}

.admin-table th {
    background: #f5f3fa;
    color: #444;
    text-align: left;
    padding: 12px 11px;
    border-bottom: 1px solid #ddd8e9;
    font-size: 12px;
    font-weight: 700;
    white-space: nowrap;
}

.admin-table td {
    padding: 13px 11px;
    border-bottom: 1px solid #eeeeee;
    font-size: 12px;
    vertical-align: middle;
}

.admin-table tbody tr:hover {
    background: #fbfaff;
}

.course-name {
    font-weight: 700;
    color: #333;
}

.course-subtext {
    margin-top: 4px;
    font-size: 11px;
    color: #888;
}

.code-badge {
    display: inline-block;
    padding: 4px 8px;
    background: #f0ebfa;
    color: #6f42c1;
    border-radius: 5px;
    font-size: 11px;
    font-weight: 700;
}

.department-badge {
    display: inline-block;
    padding: 5px 8px;
    background: #eaf3ff;
    color: #0d6efd;
    border-radius: 5px;
    font-size: 11px;
    font-weight: 600;
}

.not-assigned {
    display: inline-block;
    padding: 5px 8px;
    background: #fff3cd;
    color: #856404;
    border-radius: 5px;
    font-size: 11px;
    font-weight: 600;
}

.status-badge {
    display: inline-block;
    padding: 5px 9px;
    border-radius: 15px;
    font-size: 10px;
    font-weight: 700;
}

.status-active {
    background: #d1e7dd;
    color: #0f5132;
}

.status-inactive {
    background: #f8d7da;
    color: #842029;
}

.action-row {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
}

.action-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 7px 9px;
    border: none;
    border-radius: 5px;
    font-size: 10px;
    font-weight: 700;
    text-decoration: none;
    cursor: pointer;
    white-space: nowrap;
}

.action-edit {
    background: #eee7fb;
    color: #6f42c1;
}

.action-edit:hover {
    background: #e0d5f4;
    color: #59339d;
}

.action-disable {
    background: #f8d7da;
    color: #842029;
}

.action-disable:hover {
    background: #f1bfc5;
}

.action-enable {
    background: #d1e7dd;
    color: #0f5132;
}

.action-enable:hover {
    background: #bde0ca;
}

.admin-alert-success {
    background: #d1e7dd;
    color: #0f5132;
    border: 1px solid #badbcc;
}

.admin-info-box {
    margin-top: 20px;
    background: #f7f5fc;
    border: 1px solid #e4dff2;
    border-radius: 8px;
    padding: 15px 17px;
    font-size: 13px;
    line-height: 1.5;
}

.admin-info-box strong {
    color: #6f42c1;
}

.admin-info-box p {
    margin: 5px 0;
}

.empty-state {
    text-align: center;
    padding: 55px 20px;
    color: #777;
}

.empty-icon {
    font-size: 45px;
    margin-bottom: 10px;
}

.empty-state h3 {
    margin: 0 0 6px;
    color: #444;
}

.empty-state p {
    margin: 0 0 18px;
}

@media (max-width: 1200px) {

    .course-summary-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

}

@media (max-width: 700px) {

    .course-summary-grid {
        grid-template-columns: 1fr;
    }

    .admin-page-head {
        flex-direction: column;
        align-items: flex-start;
    }

}

</style>

@endsection