@extends('admin.layouts.app')

@section('title', 'Edit Staff - College ERP')

@section('content')

<div class="admin-page-head">
    <div>
        <h1>✏️ Edit Staff</h1>
        <p>Update staff account and profile details.</p>
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
            <div class="admin-panel-title">{{ $staff->user?->name ?? 'Staff' }}</div>
            <div class="admin-panel-subtitle">Employee Code: {{ $staff->employee_code }}</div>
        </div>
    </div>

    <form action="{{ route('admin.staff.update', $staff) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="admin-form-grid">

            <div class="admin-form-group">
                <label for="name">Staff Name <span>*</span></label>
                <input id="name" type="text" name="name" value="{{ old('name', $staff->user?->name) }}" required>
            </div>

            <div class="admin-form-group">
                <label for="employee_code">Employee Code <span>*</span></label>
                <input id="employee_code" type="text" name="employee_code" value="{{ old('employee_code', $staff->employee_code) }}" required>
            </div>

            <div class="admin-form-group">
                <label for="email">Login Email <span>*</span></label>
                <input id="email" type="email" name="email" value="{{ old('email', $staff->user?->email) }}" required>
            </div>

            <div class="admin-form-group">
                <label for="phone">Phone</label>
                <input id="phone" type="text" name="phone" value="{{ old('phone', $staff->user?->phone) }}">
            </div>

            <div class="admin-form-group">
                <label for="designation">Designation <span>*</span></label>
                <input id="designation" type="text" name="designation" value="{{ old('designation', $staff->designation) }}" required>
            </div>

            <div class="admin-form-group">
                <label for="joining_date">Joining Date</label>
                <input id="joining_date" type="date" name="joining_date" value="{{ old('joining_date', optional($staff->joining_date)->format('Y-m-d')) }}">
            </div>

            <div class="admin-form-group">
                <label for="password">New Password</label>
                <input id="password" type="password" name="password" minlength="8">
                <small>Leave blank to keep the current password.</small>
            </div>

            <div class="admin-form-group">
                <label for="password_confirmation">Confirm New Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" minlength="8">
            </div>

        </div>

        <div class="admin-check-row">
            <label>
                <input type="checkbox" name="is_active" value="1" {{ $staff->is_active ? 'checked' : '' }}>
                Staff account is Active
            </label>
        </div>

        <div class="admin-form-actions">
            <a href="{{ route('admin.staff.index') }}" class="admin-btn admin-btn-secondary">Cancel</a>
            <button type="submit" class="admin-btn admin-btn-primary">Save Changes</button>
        </div>

    </form>

</div>

@endsection
