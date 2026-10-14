@extends('admin.layouts.app')

@section('title', 'Staff Management - College ERP')

@section('content')

<div class="admin-page-head">
    <div>
        <h1>👥 Staff Management</h1>
        <p>Manage staff accounts and unit teacher profiles.</p>
    </div>

    <a href="{{ route('admin.staff.create') }}" class="admin-btn admin-btn-primary">
        ➕ Add Staff
    </a>
</div>

<div class="admin-page-line"></div>

@if(session('success'))
    <div class="admin-alert admin-alert-success">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="admin-alert admin-alert-danger">
        @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

<div class="admin-panel">

    <div class="admin-panel-header">
        <div>
            <div class="admin-panel-title">Staff List</div>
            <div class="admin-panel-subtitle">All staff accounts created by the Administrator</div>
        </div>

        <div class="admin-count-badge">
            {{ $staff->total() }} Staff
        </div>
    </div>

    <div style="overflow-x:auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Employee Code</th>
                    <th>Staff Name</th>
                    <th>Login Email</th>
                    <th>Designation</th>
                    <th>Phone</th>
                    <th>Joining Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($staff as $index => $profile)
                    <tr>
                        <td>{{ $staff->firstItem() + $index }}</td>
                        <td><strong>{{ $profile->employee_code }}</strong></td>
                        <td>{{ $profile->user?->name ?? '-' }}</td>
                        <td>{{ $profile->user?->email ?? '-' }}</td>
                        <td>{{ $profile->designation ?? '-' }}</td>
                        <td>{{ $profile->user?->phone ?? '-' }}</td>
                        <td>{{ $profile->joining_date?->format('d-m-Y') ?? '-' }}</td>
                        <td>
                            @if($profile->is_active && ($profile->user?->is_active ?? false))
                                <span class="admin-status admin-status-active">ACTIVE</span>
                            @else
                                <span class="admin-status admin-status-inactive">INACTIVE</span>
                            @endif
                        </td>
                        <td>
                            <div class="admin-actions">
                                <a href="{{ route('admin.staff.edit', $profile) }}" class="admin-btn admin-btn-small admin-btn-secondary">
                                    Edit
                                </a>

                                <form action="{{ route('admin.staff.toggle', $profile) }}" method="POST" style="margin:0;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="admin-btn admin-btn-small {{ $profile->is_active ? 'admin-btn-danger' : 'admin-btn-success' }}">
                                        {{ $profile->is_active ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="admin-empty">
                            No staff accounts found. Click <strong>Add Staff</strong> to create the first account.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($staff->hasPages())
        <div class="admin-pagination">
            {{ $staff->links() }}
        </div>
    @endif

</div>

@endsection
