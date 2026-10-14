@extends('admin.layouts.app')

@section('title', 'Add Course - College ERP')

@section('content')

<div class="admin-page-head">

    <div>

        <h1>➕ Add Course / Programme</h1>

        <p>
            Add a new course or programme and assign it to a department.
        </p>

    </div>


    <a
        href="{{ route('admin.courses.index') }}"
        class="admin-btn admin-btn-secondary"
    >
        ← Back to Course List
    </a>

</div>


<div class="admin-page-line"></div>


{{-- =========================================================
     VALIDATION ERRORS
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
     COURSE FORM
========================================================= --}}

<div class="admin-panel admin-form-panel">


    <div class="admin-panel-header">

        <div>

            <div class="admin-panel-title">
                Course / Programme Information
            </div>

            <div class="admin-panel-subtitle">
                Enter the course details and select the department.
            </div>

        </div>

    </div>


    <form
        action="{{ route('admin.courses.store') }}"
        method="POST"
    >

        @csrf


        <div class="admin-form-grid">


            {{-- =================================================
                 DEPARTMENT
            ================================================== --}}

            <div class="admin-form-group">

                <label for="department_id">

                    Department
                    <span>*</span>

                </label>


                <select
                    id="department_id"
                    name="department_id"
                    required
                >

                    <option value="">
                        Select Department
                    </option>


                    @foreach($departments as $department)

                        <option
                            value="{{ $department->id }}"
                            @selected(
                                old('department_id') ==
                                $department->id
                            )
                        >

                            {{ $department->name }}

                            @if(!empty($department->code))

                                ({{ $department->code }})

                            @endif

                        </option>

                    @endforeach

                </select>


                <small>
                    Only active departments are shown.
                </small>

            </div>



            {{-- =================================================
                 COURSE NAME
            ================================================== --}}

            <div class="admin-form-group">

                <label for="name">

                    Course / Programme Name
                    <span>*</span>

                </label>


                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="e.g. Bachelor of Computer Applications"
                    required
                >

            </div>



            {{-- =================================================
                 COURSE CODE
            ================================================== --}}

            <div class="admin-form-group">

                <label for="code">

                    Course Code
                    <span>*</span>

                </label>


                <input
                    id="code"
                    type="text"
                    name="code"
                    value="{{ old('code') }}"
                    placeholder="e.g. BCA"
                    maxlength="255"
                    required
                >


                <small>
                    Course code must be unique.
                </small>

            </div>



            {{-- =================================================
                 DURATION
            ================================================== --}}

            <div class="admin-form-group">

                <label for="duration">

                    Duration

                </label>


                <input
                    id="duration"
                    type="text"
                    name="duration"
                    value="{{ old('duration') }}"
                    placeholder="e.g. 3 Years"
                >

            </div>



            {{-- =================================================
                 ADMISSION FEE
            ================================================== --}}

            <div class="admin-form-group">

                <label for="admission_fee">

                    Admission Fee
                    <span>*</span>

                </label>


                <div class="admin-input-prefix">

                    <span>₹</span>

                    <input
                        id="admission_fee"
                        type="number"
                        name="admission_fee"
                        value="{{ old('admission_fee', 0) }}"
                        min="0"
                        step="0.01"
                        required
                    >

                </div>

            </div>



            {{-- =================================================
                 ANNUAL FEE
            ================================================== --}}

            <div class="admin-form-group">

                <label for="annual_fee">

                    Annual Fee
                    <span>*</span>

                </label>


                <div class="admin-input-prefix">

                    <span>₹</span>

                    <input
                        id="annual_fee"
                        type="number"
                        name="annual_fee"
                        value="{{ old('annual_fee', 0) }}"
                        min="0"
                        step="0.01"
                        required
                    >

                </div>

            </div>


        </div>


        {{-- =================================================
             INFORMATION BOX
        ================================================== --}}

        <div class="admin-info-box">

            <strong>
                Course Management
            </strong>

            <p>
                The selected department will control where this
                course appears in the student admission form.
            </p>

            <p>
                Only active courses will be available for student
                admission.
            </p>

        </div>


        {{-- =================================================
             BUTTONS
        ================================================== --}}

        <div class="admin-form-actions">


            <a
                href="{{ route('admin.courses.index') }}"
                class="admin-btn admin-btn-secondary"
            >

                Cancel

            </a>


            <button
                type="submit"
                class="admin-btn admin-btn-primary"
            >

                💾 Save Course

            </button>


        </div>


    </form>


</div>


{{-- =========================================================
     PAGE-SPECIFIC STYLES
========================================================= --}}

<style>

.admin-form-panel {
    max-width: 1000px;
}

.admin-form-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 20px;
}

.admin-form-group {
    display: flex;
    flex-direction: column;
}

.admin-form-group label {
    display: block;
    margin-bottom: 7px;
    font-size: 13px;
    font-weight: 700;
    color: #333;
}

.admin-form-group label span {
    color: #dc3545;
}

.admin-form-group input,
.admin-form-group select {
    width: 100%;
    padding: 11px 12px;
    border: 1px solid #d9d9e3;
    border-radius: 7px;
    background: #fff;
    color: #333;
    font-size: 14px;
    outline: none;
    transition: 0.2s ease;
}

.admin-form-group input:focus,
.admin-form-group select:focus {
    border-color: #6f42c1;
    box-shadow: 0 0 0 3px rgba(111, 66, 193, 0.10);
}

.admin-form-group small {
    margin-top: 6px;
    font-size: 11px;
    color: #777;
}

.admin-input-prefix {
    display: flex;
    align-items: stretch;
}

.admin-input-prefix span {
    min-width: 42px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f4f2fa;
    color: #6f42c1;
    border: 1px solid #d9d9e3;
    border-right: 0;
    border-radius: 7px 0 0 7px;
    font-weight: 700;
}

.admin-input-prefix input {
    border-radius: 0 7px 7px 0;
}

.admin-info-box {
    margin-top: 25px;
    padding: 15px 17px;
    border-radius: 8px;
    background: #f7f5fc;
    border: 1px solid #e4dff2;
    color: #444;
    font-size: 13px;
}

.admin-info-box strong {
    display: block;
    color: #6f42c1;
    font-size: 14px;
    margin-bottom: 7px;
}

.admin-info-box p {
    margin: 4px 0;
    line-height: 1.5;
}

.admin-form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 25px;
    padding-top: 20px;
    border-top: 1px solid #eee;
}

.admin-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 10px 18px;
    border-radius: 7px;
    text-decoration: none;
    border: 0;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
}

.admin-btn-primary {
    background: #6f42c1;
    color: #fff;
}

.admin-btn-primary:hover {
    background: #59339d;
    color: #fff;
}

.admin-btn-secondary {
    background: #6c757d;
    color: #fff;
}

.admin-btn-secondary:hover {
    background: #5c636a;
    color: #fff;
}

.admin-alert {
    padding: 13px 15px;
    border-radius: 7px;
    margin-bottom: 20px;
    font-size: 13px;
}

.admin-alert-danger {
    background: #f8d7da;
    color: #842029;
    border: 1px solid #f5c2c7;
}

.admin-page-head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
}

.admin-page-head h1 {
    margin: 0 0 5px;
}

.admin-page-head p {
    margin: 0;
    color: #777;
    font-size: 13px;
}

.admin-page-line {
    height: 1px;
    background: #e6e6ec;
    margin: 20px 0;
}

@media (max-width: 800px) {

    .admin-form-grid {
        grid-template-columns: 1fr;
    }

    .admin-page-head {
        flex-direction: column;
        align-items: flex-start;
    }

    .admin-form-actions {
        justify-content: stretch;
        flex-direction: column;
    }

    .admin-form-actions .admin-btn {
        width: 100%;
    }

}

</style>

@endsection