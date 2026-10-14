@extends('admin.layouts.app')

@section('title', 'Programme Academic Structure - College ERP')

@section('content')

<style>

    .academic-editor {
        max-width: 1050px;
        margin: 0 auto;
    }

    .editor-header {
        background: linear-gradient(
            135deg,
            #40358f,
            #6657bb
        );
        color: white;
        border-radius: 14px;
        padding: 24px;
        margin-bottom: 22px;
    }

    .editor-header h2 {
        margin: 0 0 5px;
    }

    .editor-header p {
        margin: 0;
        opacity: 0.9;
    }

    .card-box {
        background: white;
        border: 1px solid #e6e6ee;
        border-radius: 14px;
        padding: 22px;
        margin-bottom: 20px;
    }

    .card-title {
        margin: 0 0 18px;
        color: #40358f;
        font-size: 18px;
        font-weight: 700;
    }

    .info-grid {
        display: grid;
        grid-template-columns:
            repeat(
                auto-fit,
                minmax(220px, 1fr)
            );
        gap: 14px;
    }

    .info-box {
        background: #f7f7fb;
        border-radius: 9px;
        padding: 13px;
    }

    .info-label {
        font-size: 11px;
        color: #777;
        text-transform: uppercase;
        margin-bottom: 4px;
    }

    .info-value {
        font-weight: 700;
        color: #333;
    }

    .pattern-options {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }

    .pattern-option {
        border: 2px solid #e1e1ea;
        border-radius: 12px;
        padding: 18px;
        cursor: pointer;
        transition: 0.2s;
    }

    .pattern-option:hover {
        border-color: #40358f;
    }

    .pattern-option input {
        margin-right: 8px;
    }

    .pattern-title {
        font-weight: 700;
        color: #40358f;
        margin-bottom: 5px;
    }

    .pattern-description {
        color: #666;
        font-size: 12px;
        line-height: 1.5;
    }

    .form-label-custom {
        display: block;
        font-weight: 700;
        margin-bottom: 7px;
        color: #333;
    }

    .form-control-custom {
        width: 100%;
        padding: 11px 13px;
        border: 1px solid #ced4da;
        border-radius: 8px;
        background: white;
    }

    .structure-preview {
        margin-top: 20px;
    }

    .year-preview {
        background: #f7f7fb;
        border: 1px solid #e5e5eb;
        border-radius: 10px;
        padding: 13px;
        margin-bottom: 10px;
    }

    .year-preview-title {
        font-weight: 700;
        color: #40358f;
        margin-bottom: 6px;
    }

    .semester-preview {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }

    .semester-pill {
        background: #40358f;
        color: white;
        padding: 5px 9px;
        border-radius: 14px;
        font-size: 11px;
        font-weight: 700;
    }

    .btn-row {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 22px;
    }

    .btn-primary-custom {
        border: none;
        background: #40358f;
        color: white;
        padding: 11px 18px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 700;
    }

    .btn-secondary-custom {
        text-decoration: none;
        background: #6c757d;
        color: white;
        padding: 11px 18px;
        border-radius: 8px;
        font-weight: 700;
    }

    @media (max-width: 700px) {

        .pattern-options {
            grid-template-columns: 1fr;
        }

    }

</style>

<div class="academic-editor">

    <div class="editor-header">

        <h2>
            {{ $course->name }}
        </h2>

        <p>
            Configure programme academic pattern,
            years and semesters.
        </p>

    </div>


    {{-- COURSE INFORMATION --}}
    <div class="card-box">

        <h3 class="card-title">
            Programme Information
        </h3>

        <div class="info-grid">

            <div class="info-box">

                <div class="info-label">
                    Programme Code
                </div>

                <div class="info-value">
                    {{ $course->code }}
                </div>

            </div>


            <div class="info-box">

                <div class="info-label">
                    Program Group
                </div>

                <div class="info-value">
                    {{ $course->department?->programGroup?->name ?? '-' }}
                </div>

            </div>


            <div class="info-box">

                <div class="info-label">
                    Department
                </div>

                <div class="info-value">
                    {{ $course->department?->name ?? '-' }}
                </div>

            </div>


            <div class="info-box">

                <div class="info-label">
                    Sub-Department
                </div>

                <div class="info-value">
                    {{ $course->subDepartment?->name ?? '-' }}
                </div>

            </div>

        </div>

    </div>


    {{-- CONFIGURATION --}}
    <div class="card-box">

        <h3 class="card-title">
            Academic Pattern
        </h3>

        <form
            method="POST"
            action="{{ route(
                'admin.academic-structure.course.update',
                $course
            ) }}"
        >

            @csrf
            @method('PUT')


            <div style="margin-bottom:20px;">

                <label class="form-label-custom">
                    Study Pattern
                </label>

                <div class="pattern-options">

                    <label class="pattern-option">

                        <div class="pattern-title">

                            <input
                                type="radio"
                                name="study_pattern"
                                value="semester"
                                {{ old(
                                    'study_pattern',
                                    $course->study_pattern
                                ) === 'semester'
                                    ? 'checked'
                                    : ''
                                }}
                            >

                            Semester-wise

                        </div>

                        <div class="pattern-description">

                            Example:
                            1st Year =
                            Semester 1 & 2.

                            2nd Year =
                            Semester 3 & 4.

                        </div>

                    </label>


                    <label class="pattern-option">

                        <div class="pattern-title">

                            <input
                                type="radio"
                                name="study_pattern"
                                value="yearly"
                                {{ old(
                                    'study_pattern',
                                    $course->study_pattern
                                ) === 'yearly'
                                    ? 'checked'
                                    : ''
                                }}
                            >

                            Yearly

                        </div>

                        <div class="pattern-description">

                            Example:
                            1st Year,
                            2nd Year,
                            3rd Year,
                            4th Year.

                        </div>

                    </label>

                </div>

                @error('study_pattern')

                    <div style="color:#dc3545;margin-top:7px;">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            <div style="max-width:320px;">

                <label class="form-label-custom">
                    Total Years
                </label>

                <input
                    type="number"
                    name="total_years"
                    min="1"
                    max="8"
                    value="{{ old(
                        'total_years',
                        $course->total_years
                    ) }}"
                    class="form-control-custom"
                    required
                >

                @error('total_years')

                    <div style="color:#dc3545;margin-top:7px;">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            <div class="btn-row">

                <button
                    type="submit"
                    class="btn-primary-custom"
                >
                    Save Academic Structure
                </button>

                <a
                    href="{{ route(
                        'admin.academic-structure.index',
                        [
                            'group' =>
                                $course->department?->program_group_id
                        ]
                    ) }}"
                    class="btn-secondary-custom"
                >
                    Back
                </a>

            </div>

        </form>

    </div>


    {{-- CURRENT STRUCTURE --}}
    <div class="card-box">

        <h3 class="card-title">
            Current Academic Structure
        </h3>

        @if($course->years->where('is_active', true)->count())

            <div class="structure-preview">

                @foreach(
                    $course->years->where('is_active', true)
                    as $year
                )

                    <div class="year-preview">

                        <div class="year-preview-title">
                            {{ $year->name }}
                        </div>


                        @if(
                            $course->study_pattern === 'semester'
                            && $year->semesters->count()
                        )

                            <div class="semester-preview">

                                @foreach(
                                    $year->semesters
                                        ->where('is_active', true)
                                    as $yearSemester
                                )

                                    <span class="semester-pill">

                                        Semester
                                        {{ $yearSemester->semester->semester_number }}

                                    </span>

                                @endforeach

                            </div>

                        @elseif($course->study_pattern === 'yearly')

                            <div style="color:#198754;font-size:12px;">
                                Yearly Programme
                            </div>

                        @else

                            <div style="color:#856404;font-size:12px;">
                                Academic pattern not configured.
                            </div>

                        @endif

                    </div>

                @endforeach

            </div>

        @else

            <div
                style="
                    padding:20px;
                    background:#f8f9fa;
                    border-radius:9px;
                    color:#777;
                "
            >
                No academic years have been configured yet.
            </div>

        @endif

    </div>

</div>

@endsection