@extends('admin.layouts.app')

@section('title', 'Programme Summary - College ERP')

@section('content')

<style>

    * {
        box-sizing: border-box;
    }

    .summary-page {
        padding-bottom: 40px;
    }

    /*
    |--------------------------------------------------------------------------
    | PAGE HEADER
    |--------------------------------------------------------------------------
    */

    .summary-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
        margin-bottom: 25px;
        flex-wrap: wrap;
    }

    .summary-header h2 {
        margin: 0;
        font-size: 28px;
        font-weight: 800;
        color: #30285f;
    }

    .summary-header p {
        margin: 7px 0 0;
        color: #777;
        font-size: 14px;
    }


    /*
    |--------------------------------------------------------------------------
    | SUMMARY STAT CARDS
    |--------------------------------------------------------------------------
    */

    .stats-grid {
        display: grid;
        grid-template-columns:
            repeat(
                5,
                minmax(150px, 1fr)
            );

        gap: 16px;
        margin-bottom: 28px;
    }

    .stat-card {
        background: #ffffff;
        border-radius: 14px;
        padding: 20px;
        border: 1px solid #e7e7ef;
        box-shadow:
            0 5px 18px
            rgba(0, 0, 0, 0.05);
    }

    .stat-label {
        font-size: 12px;
        color: #777;
        margin-bottom: 8px;
        text-transform: uppercase;
        font-weight: 700;
    }

    .stat-value {
        font-size: 28px;
        font-weight: 800;
        color: #40358f;
    }


    /*
    |--------------------------------------------------------------------------
    | FILTER BAR
    |--------------------------------------------------------------------------
    */

    .filter-card {
        background: #ffffff;
        border: 1px solid #e7e7ef;
        border-radius: 14px;
        padding: 16px;
        margin-bottom: 25px;
        box-shadow:
            0 3px 14px
            rgba(0, 0, 0, 0.04);
    }

    .filter-title {
        font-size: 13px;
        font-weight: 800;
        color: #40358f;
        margin-bottom: 10px;
    }

    .filter-buttons {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .filter-button {
        text-decoration: none;
        padding: 8px 13px;
        border-radius: 20px;
        border: 1px solid #ddd9ed;
        background: #faf9fd;
        color: #40358f;
        font-size: 12px;
        font-weight: 700;
    }

    .filter-button:hover,
    .filter-button.active {
        background: #40358f;
        color: #ffffff;
        border-color: #40358f;
    }


    /*
    |--------------------------------------------------------------------------
    | PROGRAM GROUP
    |--------------------------------------------------------------------------
    */

    .program-group-card {
        background: #ffffff;
        border: 1px solid #e4e3ed;
        border-radius: 18px;
        overflow: hidden;
        margin-bottom: 28px;
        box-shadow:
            0 7px 24px
            rgba(0, 0, 0, 0.06);
    }

    .program-group-header {
        background:
            linear-gradient(
                135deg,
                #40358f,
                #6759bb
            );

        color: white;
        padding: 22px 24px;
    }

    .program-group-title {
        font-size: 23px;
        font-weight: 800;
        margin: 0 0 5px;
    }

    .program-group-subtitle {
        font-size: 12px;
        opacity: 0.88;
        margin: 0;
    }

    .group-code {
        display: inline-block;
        margin-left: 8px;
        background: rgba(
            255,
            255,
            255,
            0.18
        );
        padding: 4px 9px;
        border-radius: 15px;
        font-size: 10px;
        font-weight: 700;
    }


    /*
    |--------------------------------------------------------------------------
    | DEPARTMENT
    |--------------------------------------------------------------------------
    */

    .department-section {
        padding: 20px 22px;
        border-bottom: 1px solid #eeeeee;
    }

    .department-section:last-child {
        border-bottom: 0;
    }

    .department-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
        margin-bottom: 16px;
    }

    .department-name {
        margin: 0;
        color: #322c59;
        font-size: 20px;
        font-weight: 800;
    }

    .department-code {
        display: inline-block;
        margin-left: 8px;
        background: #eeecf8;
        color: #40358f;
        padding: 4px 9px;
        border-radius: 15px;
        font-size: 10px;
        font-weight: 800;
    }


    /*
    |--------------------------------------------------------------------------
    | SUB DEPARTMENT
    |--------------------------------------------------------------------------
    */

    .subdepartment-block {
        margin-bottom: 18px;
    }

    .subdepartment-block:last-child {
        margin-bottom: 0;
    }

    .subdepartment-title {
        font-size: 14px;
        font-weight: 800;
        color: #40358f;
        margin-bottom: 12px;
    }


    /*
    |--------------------------------------------------------------------------
    | PROGRAMME CARDS
    |--------------------------------------------------------------------------
    */

    .programme-grid {
        display: grid;

        grid-template-columns:
            repeat(
                auto-fit,
                minmax(320px, 1fr)
            );

        gap: 15px;
    }

    .programme-card {
        background: #fbfbfd;
        border: 1px solid #e4e4eb;
        border-radius: 13px;
        padding: 17px;
    }

    .programme-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 6px;
    }

    .programme-name {
        color: #30285f;
        font-size: 17px;
        font-weight: 800;
        margin: 0;
    }

    .programme-code {
        font-size: 10px;
        color: #777;
        margin-bottom: 14px;
    }

    .pattern-badge {
        display: inline-block;
        padding: 5px 9px;
        border-radius: 15px;
        font-size: 9px;
        font-weight: 800;
        white-space: nowrap;
    }

    .semester-badge {
        background: #e5efff;
        color: #0d6efd;
    }

    .yearly-badge {
        background: #e5f7ed;
        color: #198754;
    }

    .pending-badge {
        background: #fff3cd;
        color: #856404;
    }


    /*
    |--------------------------------------------------------------------------
    | PROGRAMME INFO
    |--------------------------------------------------------------------------
    */

    .programme-info {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
        margin-bottom: 15px;
    }

    .info-item {
        background: #ffffff;
        border-radius: 7px;
        padding: 9px;
    }

    .info-label {
        font-size: 9px;
        color: #888;
        text-transform: uppercase;
        font-weight: 700;
        margin-bottom: 3px;
    }

    .info-value {
        font-size: 12px;
        color: #333;
        font-weight: 800;
    }


    /*
    |--------------------------------------------------------------------------
    | YEAR BOX
    |--------------------------------------------------------------------------
    */

    .academic-years {
        border-top: 1px solid #e7e7eb;
        padding-top: 13px;
    }

    .academic-years-title {
        font-size: 11px;
        text-transform: uppercase;
        font-weight: 800;
        color: #777;
        margin-bottom: 9px;
    }

    .year-box {
        background: #ffffff;
        border: 1px solid #e6e6ec;
        border-radius: 9px;
        padding: 10px;
        margin-bottom: 8px;
    }

    .year-box:last-child {
        margin-bottom: 0;
    }

    .year-title {
        font-size: 12px;
        font-weight: 800;
        color: #40358f;
        margin-bottom: 7px;
    }


    /*
    |--------------------------------------------------------------------------
    | SEMESTER PILLS
    |--------------------------------------------------------------------------
    */

    .semester-row {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }

    .semester-pill {
        background: #40358f;
        color: white;
        padding: 5px 9px;
        border-radius: 15px;
        font-size: 9px;
        font-weight: 800;
    }


    /*
    |--------------------------------------------------------------------------
    | YEARLY LABEL
    |--------------------------------------------------------------------------
    */

    .yearly-label {
        display: inline-block;
        background: #e5f7ed;
        color: #198754;
        padding: 5px 9px;
        border-radius: 15px;
        font-size: 9px;
        font-weight: 800;
    }


    /*
    |--------------------------------------------------------------------------
    | MANAGE BUTTON
    |--------------------------------------------------------------------------
    */

    .programme-footer {
        margin-top: 15px;
    }

    .manage-button {
        display: inline-block;
        text-decoration: none;
        background: #40358f;
        color: #ffffff;
        padding: 8px 12px;
        border-radius: 7px;
        font-size: 10px;
        font-weight: 800;
    }

    .manage-button:hover {
        background: #30286f;
        color: white;
    }


    /*
    |--------------------------------------------------------------------------
    | EMPTY
    |--------------------------------------------------------------------------
    */

    .empty-box {
        text-align: center;
        background: #ffffff;
        border: 1px solid #e7e7ef;
        border-radius: 15px;
        padding: 45px 20px;
        color: #777;
    }


    /*
    |--------------------------------------------------------------------------
    | RESPONSIVE
    |--------------------------------------------------------------------------
    */

    @media (max-width: 1100px) {

        .stats-grid {
            grid-template-columns:
                repeat(3, 1fr);
        }

    }

    @media (max-width: 700px) {

        .stats-grid {
            grid-template-columns:
                repeat(2, 1fr);
        }

        .programme-info {
            grid-template-columns: 1fr;
        }

        .programme-grid {
            grid-template-columns: 1fr;
        }

    }

</style>


<div class="summary-page">


    {{-- =====================================================
         PAGE HEADER
    ====================================================== --}}

    <div class="summary-header">

        <div>

            <h2>
                Programme Summary
            </h2>

            <p>
                Complete academic structure of all
                Program Groups, Departments,
                Programmes, Years and Semesters.
            </p>

        </div>

    </div>


    {{-- =====================================================
         SUCCESS MESSAGE
    ====================================================== --}}

    @if(session('success'))

        <div
            style="
                background:#d1e7dd;
                color:#0f5132;
                padding:14px 16px;
                border-radius:10px;
                margin-bottom:20px;
            "
        >
            {{ session('success') }}
        </div>

    @endif


    {{-- =====================================================
         TOP SUMMARY CARDS
    ====================================================== --}}

    <div class="stats-grid">

        <div class="stat-card">

            <div class="stat-label">
                Program Groups
            </div>

            <div class="stat-value">
                {{ $totalGroups }}
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-label">
                Departments
            </div>

            <div class="stat-value">
                {{ $totalDepartments }}
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-label">
                Sub-Departments
            </div>

            <div class="stat-value">
                {{ $totalSubDepartments }}
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-label">
                Programmes
            </div>

            <div class="stat-value">
                {{ $totalProgrammes }}
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-label">
                Academic Configured
            </div>

            <div class="stat-value">
                {{ $configuredProgrammes }}
            </div>

        </div>

    </div>


    {{-- =====================================================
         FILTER BUTTONS
    ====================================================== --}}

    <div class="filter-card">

        <div class="filter-title">
            View Summary
        </div>

        <div class="filter-buttons">

            <a
                href="{{ route('admin.academic-structure.index') }}"
                class="filter-button
                    {{ !$selectedGroupId ? 'active' : '' }}"
            >
                All Program Groups
            </a>


            @php
                $filterGroups = \App\Models\ProgramGroup::where(
                    'is_active',
                    true
                )
                ->orderBy('name')
                ->get();
            @endphp


            @foreach($filterGroups as $group)

                <a
                    href="{{ route(
                        'admin.academic-structure.index',
                        ['group' => $group->id]
                    ) }}"
                    class="filter-button
                        {{
                            (int) $selectedGroupId ===
                            (int) $group->id
                                ? 'active'
                                : ''
                        }}"
                >
                    {{ $group->name }}
                </a>

            @endforeach

        </div>

    </div>


    {{-- =====================================================
         ALL PROGRAM GROUPS
    ====================================================== --}}

    @forelse($programGroups as $programGroup)

        <div class="program-group-card">


            {{-- PROGRAM GROUP HEADER --}}

            <div class="program-group-header">

                <h3 class="program-group-title">

                    {{ $programGroup->name }}

                    <span class="group-code">
                        {{ $programGroup->code }}
                    </span>

                </h3>

                <p class="program-group-subtitle">

                    Academic Program Group

                </p>

            </div>


            {{-- =================================================
                 DEPARTMENTS
            ================================================== --}}

            @forelse($programGroup->departments as $department)

                <div class="department-section">


                    <div class="department-header">

                        <h4 class="department-name">

                            {{ $department->name }}

                            @if($department->code)

                                <span class="department-code">
                                    {{ $department->code }}
                                </span>

                            @endif

                        </h4>

                    </div>


                    {{-- =========================================
                         SUB DEPARTMENTS
                    ========================================== --}}

                    @forelse(
                        $department->subDepartments
                        as $subDepartment
                    )

                        <div class="subdepartment-block">

                            <div class="subdepartment-title">

                                {{ $subDepartment->name }}

                            </div>


                            {{-- =================================
                                 PROGRAMMES
                            ================================== --}}

                            <div class="programme-grid">

                                @forelse(
                                    $subDepartment->courses
                                    as $course
                                )

                                    <div class="programme-card">


                                        {{-- PROGRAMME TITLE --}}

                                        <div class="programme-top">

                                            <h5 class="programme-name">
                                                {{ $course->name }}
                                            </h5>


                                            @if(
                                                $course->study_pattern
                                                === 'semester'
                                            )

                                                <span
                                                    class="pattern-badge semester-badge"
                                                >
                                                    Semester-wise
                                                </span>

                                            @elseif(
                                                $course->study_pattern
                                                === 'yearly'
                                            )

                                                <span
                                                    class="pattern-badge yearly-badge"
                                                >
                                                    Yearly
                                                </span>

                                            @else

                                                <span
                                                    class="pattern-badge pending-badge"
                                                >
                                                    Not Configured
                                                </span>

                                            @endif

                                        </div>


                                        <div class="programme-code">

                                            Code:
                                            <strong>
                                                {{ $course->code }}
                                            </strong>

                                        </div>


                                        {{-- PROGRAMME INFO --}}

                                        <div class="programme-info">


                                            <div class="info-item">

                                                <div class="info-label">
                                                    Duration
                                                </div>

                                                <div class="info-value">
                                                    {{ $course->duration ?: 'Not Set' }}
                                                </div>

                                            </div>


                                            <div class="info-item">

                                                <div class="info-label">
                                                    Total Years
                                                </div>

                                                <div class="info-value">
                                                    {{
                                                        $course->total_years
                                                            ?: '-'
                                                    }}
                                                </div>

                                            </div>

                                        </div>


                                        {{-- =================================
                                             YEARS
                                        ================================== --}}

                                        @if(
                                            $course->years
                                                ->where('is_active', true)
                                                ->count()
                                        )

                                            <div class="academic-years">

                                                <div class="academic-years-title">

                                                    Academic Structure

                                                </div>


                                                @foreach(
                                                    $course->years
                                                        ->where(
                                                            'is_active',
                                                            true
                                                        )
                                                    as $year
                                                )

                                                    <div class="year-box">


                                                        <div class="year-title">

                                                            {{ $year->name }}

                                                        </div>


                                                        @if(
                                                            $course->study_pattern
                                                            === 'semester'
                                                            &&
                                                            $year->semesters
                                                                ->where(
                                                                    'is_active',
                                                                    true
                                                                )
                                                                ->count()
                                                        )

                                                            <div
                                                                class="semester-row"
                                                            >

                                                                @foreach(
                                                                    $year->semesters
                                                                        ->where(
                                                                            'is_active',
                                                                            true
                                                                        )
                                                                    as $yearSemester
                                                                )

                                                                    <span
                                                                        class="semester-pill"
                                                                    >

                                                                        Semester
                                                                        {{
                                                                            $yearSemester
                                                                                ->semester
                                                                                ->semester_number
                                                                        }}

                                                                    </span>

                                                                @endforeach

                                                            </div>


                                                        @elseif(
                                                            $course->study_pattern
                                                            === 'yearly'
                                                        )

                                                            <span
                                                                class="yearly-label"
                                                            >
                                                                Annual / Yearly
                                                            </span>

                                                        @else

                                                            <span
                                                                class="pattern-badge pending-badge"
                                                            >
                                                                Academic pattern
                                                                not configured
                                                            </span>

                                                        @endif

                                                    </div>

                                                @endforeach

                                            </div>

                                        @else

                                            <div
                                                style="
                                                    background:#fff8e1;
                                                    color:#856404;
                                                    padding:10px;
                                                    border-radius:8px;
                                                    font-size:10px;
                                                    margin-top:10px;
                                                "
                                            >

                                                Years / semesters not
                                                configured yet.

                                            </div>

                                        @endif


                                        {{-- MANAGE --}}

                                        <div class="programme-footer">

                                            <a
                                                href="{{ route(
                                                    'admin.academic-structure.course.edit',
                                                    $course
                                                ) }}"
                                                class="manage-button"
                                            >
                                                Manage Academic Structure
                                            </a>

                                        </div>

                                    </div>

                                @empty

                                    <div
                                        style="
                                            background:#fafafa;
                                            border:1px dashed #ddd;
                                            padding:20px;
                                            border-radius:10px;
                                            color:#777;
                                        "
                                    >
                                        No programmes found.
                                    </div>

                                @endforelse

                            </div>

                        </div>

                    @empty

                        <div
                            style="
                                background:#fafafa;
                                padding:20px;
                                border-radius:10px;
                                color:#777;
                            "
                        >

                            No sub-departments found.

                        </div>

                    @endforelse

                </div>

            @empty

                <div class="empty-box">

                    No departments found in this
                    Program Group.

                </div>

            @endforelse

        </div>

    @empty

        <div class="empty-box">

            <h3>
                No Academic Structure Available
            </h3>

            <p>
                Add Program Groups, Departments
                and Programmes to display the
                academic summary.
            </p>

        </div>

    @endforelse

</div>

@endsection