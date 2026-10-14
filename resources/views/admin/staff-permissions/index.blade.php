@extends('admin.layouts.app')

@section('title', 'Staff Permissions - College ERP')

@section('content')

<style>
    .sp-page {
        padding: 24px;
        background: #f5f6fa;
        min-height: calc(100vh - 70px);
    }

    .sp-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 20px;
    }

    .sp-header h1 {
        margin: 0;
        color: #202637;
        font-size: 25px;
        font-weight: 850;
    }

    .sp-header p {
        margin: 6px 0 0;
        color: #7d8798;
        font-size: 12px;
    }

    .sp-info {
        padding: 10px 13px;
        background: #f3f0ff;
        border: 1px solid #e5defa;
        border-radius: 11px;
        color: #5a43cd;
        font-size: 10px;
        font-weight: 800;
    }

    .sp-card {
        background: #ffffff;
        border: 1px solid #e6e9ef;
        border-radius: 18px;
        box-shadow: 0 8px 25px rgba(31,41,55,.06);
        overflow: hidden;
    }

    .sp-table-wrap {
        overflow-x: auto;
    }

    .sp-table {
        width: 100%;
        border-collapse: collapse;
    }

    .sp-table th {
        padding: 13px 15px;
        background: #fafbfc;
        border-bottom: 1px solid #e9ecf1;
        color: #7b8493;
        font-size: 9px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: .45px;
        text-align: left;
    }

    .sp-table td {
        padding: 14px 15px;
        border-bottom: 1px solid #f0f1f4;
        color: #313849;
        font-size: 11px;
        vertical-align: middle;
    }

    .sp-table tr:last-child td {
        border-bottom: 0;
    }

    .sp-staff {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .sp-avatar {
        width: 38px;
        height: 38px;
        flex: 0 0 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 11px;
        color: #ffffff;
        font-size: 11px;
        font-weight: 900;
        background: linear-gradient(135deg,#7258e7,#5037bf);
    }

    .sp-name {
        font-weight: 850;
    }

    .sp-email {
        margin-top: 3px;
        color: #9299a7;
        font-size: 9px;
    }

    .sp-code {
        display: inline-flex;
        padding: 5px 8px;
        border-radius: 7px;
        background: #f5f6f8;
        border: 1px solid #e4e7ec;
        font-size: 9px;
        font-weight: 900;
        color: #596273;
    }

    .sp-permission-count {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 9px;
        border-radius: 999px;
        background: #eefaf5;
        color: #08784f;
        border: 1px solid #d5eee1;
        font-size: 9px;
        font-weight: 900;
    }

    .sp-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 11px;
        border-radius: 9px;
        text-decoration: none;
        background: linear-gradient(135deg,#f2efff,#e9e4ff);
        color: #5940d0;
        border: 1px solid #e3dcfa;
        font-size: 9px;
        font-weight: 900;
    }

    .sp-btn:hover {
        background: linear-gradient(135deg,#e9e3ff,#ddd5ff);
    }

    .sp-empty {
        padding: 35px;
        text-align: center;
        color: #9199a7;
        font-size: 11px;
    }

    @media (max-width: 700px) {
        .sp-page {
            padding: 15px;
        }

        .sp-header {
            flex-direction: column;
        }
    }
</style>

<div class="sp-page">

    <div class="sp-header">

        <div>
            <h1>Staff Permissions</h1>

            <p>
                Give individual module access to each Unit Teacher / Staff member.
            </p>
        </div>

        <div class="sp-info">
            🔐 Permission-based staff access
        </div>

    </div>


    <div class="sp-card">

        <div class="sp-table-wrap">

            <table class="sp-table">

                <thead>
                    <tr>
                        <th>Staff</th>
                        <th>Employee Code</th>
                        <th>Designation</th>
                        <th>Active Permissions</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($staffProfiles as $staffProfile)

                        @php
                            $activePermissionCount = $staffProfile
                                ->permissions()
                                ->where('is_active', true)
                                ->count();

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
                        @endphp


                        <tr>

                            <td>

                                <div class="sp-staff">

                                    <div class="sp-avatar">
                                        {{ $initials ?: 'ST' }}
                                    </div>

                                    <div>

                                        <div class="sp-name">
                                            {{ $staffName }}
                                        </div>

                                        <div class="sp-email">
                                            {{ $staffProfile->user?->email ?? '-' }}
                                        </div>

                                    </div>

                                </div>

                            </td>


                            <td>

                                <span class="sp-code">
                                    {{ $staffProfile->employee_code }}
                                </span>

                            </td>


                            <td>
                                {{ $staffProfile->designation ?? '-' }}
                            </td>


                            <td>

                                <span class="sp-permission-count">
                                    🔐
                                    {{ $activePermissionCount }}
                                </span>

                            </td>


                            <td>

                                <a
                                    href="{{ route('admin.staff-permissions.edit', $staffProfile) }}"
                                    class="sp-btn"
                                >
                                    ⚙ Manage Permissions
                                </a>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="5"
                                class="sp-empty"
                            >
                                No active staff members found.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
