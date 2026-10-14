@extends('admin.layouts.app')

@section('title', 'Add Staff - College ERP')

@section('content')

<div class="admin-page-head">
    <div>
        <h1>➕ Add Staff</h1>
        <p>Create a staff / unit teacher login account.</p>
    </div>

    <a href="{{ route('admin.staff.index') }}" class="admin-btn admin-btn-secondary">
        ← Back to Staff List
    </a>
</div>

<div class="admin-page-line"></div>

@if($errors->any())
    <div class="admin-alert admin-alert-danger">
        <strong>Please correct the following:</strong>
        @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

<div class="admin-panel admin-form-panel">

    <div class="admin-panel-header">
        <div>
            <div class="admin-panel-title">Staff Account Information</div>
            <div class="admin-panel-subtitle">The account will be created with role = staff.</div>
        </div>
    </div>

    <form action="{{ route('admin.staff.store') }}" method="POST">
        @csrf

        <div class="admin-form-grid">

            <div class="admin-form-group">
                <label for="name">Staff Name <span>*</span></label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required>
            </div>

            <div class="admin-form-group">
                <label for="employee_code">Employee Code <span>*</span></label>
                <input id="employee_code" type="text" name="employee_code" value="{{ old('employee_code') }}" placeholder="e.g. ST002" required>
            </div>

            <div class="admin-form-group">
                <label for="email">Login Email <span>*</span></label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required>
            </div>

            <div class="admin-form-group">
                <label for="phone">Phone</label>
                <input id="phone" type="text" name="phone" value="{{ old('phone') }}">
            </div>

            <div class="admin-form-group">
                <label for="designation">Designation <span>*</span></label>
                <input id="designation" type="text" name="designation" value="{{ old('designation') }}" placeholder="Unit Teacher / Assistant Professor" required>
            </div>

            <div class="admin-form-group">
                <label for="joining_date">Joining Date</label>
                <input id="joining_date" type="date" name="joining_date" value="{{ old('joining_date') }}">
            </div>

            <div class="admin-form-group">
                <label for="password">Password <span>*</span></label>
                <input id="password" type="password" name="password" minlength="8" required>
                <small>Minimum 8 characters.</small>
            </div>

            <div class="admin-form-group">
                <label for="password_confirmation">Confirm Password <span>*</span></label>
                <input id="password_confirmation" type="password" name="password_confirmation" minlength="8" required>
            </div>

        </div>

        <div class="admin-check-row">
            <label>
                <input type="checkbox" name="is_active" value="1" checked>
                Create account as Active
            </label>
        </div>

        <div class="admin-info-box">
            <strong>Next step:</strong>
            After creating the staff account, we will assign the staff member's academic course / semester and then give individual module permissions.
        </div>

        <div class="admin-form-actions">
            <a href="{{ route('admin.staff.index') }}" class="admin-btn admin-btn-secondary">Cancel</a>
            <button type="submit" class="admin-btn admin-btn-primary">Create Staff Account</button>
        </div>

    </form>

</div>

@endsection
