@extends('admin.layouts.app')

@section('title', 'Manage Staff Permissions - College ERP')

@section('content')

<style>
    .spe-page {
        padding: 24px;
        background: #f5f6fa;
        min-height: calc(100vh - 70px);
    }

    .spe-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        margin-bottom: 18px;
    }

    .spe-staff {
        display: flex;
        align-items: center;
        gap: 11px;
    }

    .spe-avatar {
        width: 46px;
        height: 46px;
        flex: 0 0 46px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 13px;
        background: linear-gradient(135deg,#7258e7,#5037bf);
        color: #ffffff;
        font-size: 12px;
        font-weight: 900;
    }

    .spe-header h1 {
        margin: 0;
        font-size: 21px;
        color: #202637;
        font-weight: 850;
    }

    .spe-header p {
        margin: 4px 0 0;
        color: #8a92a0;
        font-size: 10px;
    }

    .spe-back {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 9px 12px;
        border-radius: 10px;
        background: #ffffff;
        border: 1px solid #e4e7ed;
        color: #596273;
        text-decoration: none;
        font-size: 10px;
        font-weight: 800;
    }

    .spe-card {
        background: #ffffff;
        border: 1px solid #e6e9ef;
        border-radius: 18px;
        box-shadow: 0 8px 26px rgba(31,41,55,.06);
        overflow: hidden;
        margin-bottom: 18px;
    }

    .spe-card-header {
        padding: 16px 18px;
        border-bottom: 1px solid #edf0f4;
        background: linear-gradient(180deg,#ffffff,#fbfbfd);
    }

    .spe-card-header h2 {
        margin: 0;
        font-size: 14px;
        color: #2b3343;
        font-weight: 850;
    }

    .spe-card-header p {
        margin: 4px 0 0;
        font-size: 9px;
        color: #9098a6;
    }

    .spe-controls {
        display: grid;
        grid-template-columns: repeat(2,minmax(0,1fr));
        gap: 12px;
        padding: 15px 18px;
        background: #fafbfc;
        border-bottom: 1px solid #eef0f4;
    }

    .spe-field label {
        display: block;
        margin-bottom: 5px;
        color: #687181;
        font-size: 9px;
        font-weight: 850;
        text-transform: uppercase;
        letter-spacing: .35px;
    }

    .spe-field input {
        width: 100%;
        min-height: 37px;
        padding: 8px 10px;
        border: 1px solid #dfe3e9;
        border-radius: 9px;
        background: #ffffff;
        color: #343c4b;
        font-size: 10px;
        outline: none;
    }

    .spe-field input:focus {
        border-color: #9d8bf0;
        box-shadow: 0 0 0 3px rgba(104,82,232,.08);
    }

    .spe-body {
        padding: 17px 18px 20px;
    }

    .spe-group {
        margin-bottom: 18px;
    }

    .spe-group:last-child {
        margin-bottom: 0;
    }

    .spe-group-title {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 9px;
    }

    .spe-group-dot {
        width: 8px;
        height: 8px;
        border-radius: 3px;
        background: linear-gradient(135deg,#7d61f3,#5238c4);
    }

    .spe-group-title h3 {
        margin: 0;
        font-size: 11px;
        color: #424b5a;
        font-weight: 900;
    }

    .spe-permissions {
        display: grid;
        grid-template-columns: repeat(3,minmax(0,1fr));
        gap: 9px;
    }

    .spe-permission {
        position: relative;
    }

    .spe-permission input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .spe-label {
        display: block;
        min-height: 83px;
        padding: 11px;
        border: 1px solid #e5e8ee;
        border-radius: 12px;
        background: #ffffff;
        cursor: pointer;
        transition: .18s ease;
    }

    .spe-label:hover {
        border-color: #d3ccf5;
        transform: translateY(-1px);
        box-shadow: 0 5px 14px rgba(31,41,55,.05);
    }

    .spe-permission input:checked + .spe-label {
        border-color: #9a88ed;
        background: #f7f4ff;
        box-shadow: 0 6px 16px rgba(104,82,232,.09);
    }

    .spe-permission input:checked + .spe-label::after {
        content: "✓";
        position: absolute;
        right: 9px;
        top: 8px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #6449db;
        color: #ffffff;
        font-size: 11px;
        font-weight: 900;
    }

    .spe-icon {
        font-size: 17px;
    }

    .spe-perm-name {
        margin-top: 5px;
        color: #303849;
        font-size: 10px;
        font-weight: 900;
        padding-right: 22px;
    }

    .spe-perm-description {
        margin-top: 4px;
        color: #8b93a1;
        font-size: 8px;
        line-height: 1.35;
    }

    .spe-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 14px 18px;
        border-top: 1px solid #edf0f4;
        background: #fafbfc;
    }

    .spe-note {
        color: #8d95a2;
        font-size: 9px;
    }

    .spe-save {
        min-width: 130px;
        border: 0;
        border-radius: 10px;
        padding: 10px 15px;
        background: linear-gradient(135deg,#7054e8,#5437c8);
        color: #ffffff;
        font-size: 10px;
        font-weight: 900;
        cursor: pointer;
        box-shadow: 0 7px 16px rgba(84,55,200,.19);
    }

    .spe-alert {
        margin-bottom: 14px;
        padding: 11px 13px;
        border-radius: 10px;
        font-size: 10px;
        font-weight: 800;
    }

    .spe-alert-success {
        background: #edf9f4;
        color: #08784f;
        border: 1px solid #d4eee1;
    }

    .spe-alert-error {
        background: #fff3f4;
        color: #ad3045;
        border: 1px solid #f0d6db;
    }

    @media (max-width: 1000px) {
        .spe-permissions {
            grid-template-columns: repeat(2,minmax(0,1fr));
        }
    }

    @media (max-width: 700px) {
        .spe-page {
            padding: 15px;
        }

        .spe-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .spe-controls {
            grid-template-columns: 1fr;
        }

        .spe-permissions {
            grid-template-columns: 1fr;
        }

        .spe-footer {
            align-items: stretch;
            flex-direction: column;
        }
    }
</style>

@php
    $staffName =
        $staffProfile->user?->name
        ?? 'Staff Member';

    $initials =
        strtoupper(
            collect(
                preg_split(
                    '/\s+/',
                    trim($staffName)
                )
            )
            ->filter()
            ->take(2)
            ->map(
                fn($word) => substr($word, 0, 1)
            )
            ->implode('')
        );

    $permissionsByGroup =
        collect($permissionCatalogue)
            ->groupBy('group');
@endphp


<div class="spe-page">


    <div class="spe-header">


        <div class="spe-staff">

            <div class="spe-avatar">
                {{ $initials ?: 'ST' }}
            </div>


            <div>

                <h1>
                    Manage Staff Permissions
                </h1>

                <p>
                    {{ $staffName }}
                    ·
                    {{ $staffProfile->employee_code }}
                    ·
                    {{ $staffProfile->designation ?? 'Staff' }}
                </p>

            </div>

        </div>


        <a
            href="{{ route('admin.staff-permissions.index') }}"
            class="spe-back"
        >
            ← Back to Staff List
        </a>

    </div>


    @if(session('success'))

        <div class="spe-alert spe-alert-success">
            {{ session('success') }}
        </div>

    @endif


    @if($errors->any())

        <div class="spe-alert spe-alert-error">

            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach

        </div>

    @endif


    <form
        method="POST"
        action="{{ route('admin.staff-permissions.update', $staffProfile) }}"
    >

        @csrf
        @method('PUT')


        <div class="spe-card">


            <div class="spe-card-header">

                <h2>
                    Permission Validity
                </h2>

                <p>
                    Set an optional date range for all selected permissions.
                </p>

            </div>


            <div class="spe-controls">


                <div class="spe-field">

                    <label for="start_date">
                        Start Date
                    </label>

                    <input
                        type="date"
                        id="start_date"
                        name="start_date"
                        value="{{ old('start_date') }}"
                    >

                </div>


                <div class="spe-field">

                    <label for="end_date">
                        End Date
                    </label>

                    <input
                        type="date"
                        id="end_date"
                        name="end_date"
                        value="{{ old('end_date') }}"
                    >

                </div>


            </div>



            <div class="spe-body">


                @foreach($permissionsByGroup as $groupName => $permissions)


                    <div class="spe-group">


                        <div class="spe-group-title">

                            <span class="spe-group-dot"></span>

                            <h3>
                                {{ $groupName }}
                            </h3>

                        </div>


                        <div class="spe-permissions">


                            @foreach($permissions as $permission)


                                @php
                                    $existing =
                                        $existingPermissions
                                            ->get(
                                                $permission['key']
                                            );

                                    $checked =
                                        old(
                                            'permissions',
                                            $existing?->is_active
                                                ? [
                                                    $permission['key']
                                                ]
                                                : []
                                        );

                                    $isChecked =
                                        in_array(
                                            $permission['key'],
                                            $checked,
                                            true
                                        );
                                @endphp


                                <div class="spe-permission">


                                    <input
                                        type="checkbox"
                                        name="permissions[]"
                                        id="permission-{{ $permission['key'] }}"
                                        value="{{ $permission['key'] }}"
                                        {{ $isChecked ? 'checked' : '' }}
                                    >


                                    <label
                                        for="permission-{{ $permission['key'] }}"
                                        class="spe-label"
                                    >

                                        <div class="spe-icon">
                                            {{ $permission['icon'] }}
                                        </div>

                                        <div class="spe-perm-name">
                                            {{ $permission['label'] }}
                                        </div>

                                        <div class="spe-perm-description">
                                            {{ $permission['description'] }}
                                        </div>

                                    </label>


                                </div>


                            @endforeach


                        </div>


                    </div>


                @endforeach


            </div>


            <div class="spe-footer">

                <div class="spe-note">
                    Unchecked permissions will be disabled. Existing permission history remains in the database.
                </div>

                <button
                    type="submit"
                    class="spe-save"
                >
                    Save Permissions
                </button>

            </div>


        </div>


    </form>


</div>

@endsection
