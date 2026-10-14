<aside class="admin-sidebar">

    {{-- ================= ADMIN PROFILE ================= --}}
    <div class="admin-sidebar-profile">
        <div class="admin-logo">COLLEGE<br>ERP</div>
        <div class="admin-profile-name">{{ auth()->user()->name }}</div>
        <div class="admin-profile-role">College Administrator</div>
    </div>

    {{-- ================= MAIN MENU ================= --}}
    <div class="admin-section-title">Main Menu</div>

    <a href="{{ route('admin.dashboard') }}"
       class="admin-menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <span class="admin-menu-icon">🏠</span>
        <span class="admin-menu-text">Dashboard</span>
    </a>

    {{-- ================= ADMINISTRATION ================= --}}
    <div class="admin-section-title">Administration</div>

    @php
        $staffItems = [
            ['title' => 'Add Staff', 'route' => 'admin.staff.create', 'icon' => '➕'],
            ['title' => 'Staff List', 'route' => 'admin.staff.index', 'icon' => '▤'],
            ['title' => 'Role Assignment', 'route' => 'admin.staff.roles', 'icon' => '✦'],
            ['title' => 'Department Assignment', 'route' => 'admin.staff.departments', 'icon' => '▦'],
            ['title' => 'Role Assigned Record', 'route' => 'admin.staff.assignments', 'icon' => '▤'],
            ['title' => 'Staff Reports', 'route' => 'admin.staff.reports', 'icon' => '▣'],
        ];

        $admissionItems = [
            ['title' => 'Applied', 'route' => 'admin.admissions.index', 'icon' => '☷'],
            ['title' => 'Merit List', 'route' => 'admin.admissions.merit', 'icon' => '☷'],
            ['title' => 'Registered', 'route' => 'admin.admissions.registered', 'icon' => '☷'],
            ['title' => 'College Students', 'route' => 'admin.students.college', 'icon' => '☷'],
            ['title' => 'Failed Students', 'route' => 'admin.students.failed', 'icon' => '☷'],
            ['title' => 'Promoted Students', 'route' => 'admin.students.promoted', 'icon' => '☷'],
        ];
    @endphp

    {{-- STAFF MANAGEMENT ACCORDION --}}
    <button type="button"
            class="admin-menu-button {{ request()->routeIs('admin.staff.*') ? 'active open' : '' }}"
            data-admin-accordion="staffSubmenu">
        <span class="admin-menu-icon">👥</span>
        <span class="admin-menu-text">Staff Management</span>
        <span class="admin-menu-arrow">›</span>
    </button>

    <div class="admin-submenu {{ request()->routeIs('admin.staff.*') ? 'open' : '' }}" id="staffSubmenu">
        @foreach($staffItems as $item)
            @php $exists = \Illuminate\Support\Facades\Route::has($item['route']); @endphp
            <a href="{{ $exists ? route($item['route']) : '#' }}"
               class="admin-menu-item {{ $exists && request()->routeIs($item['route']) ? 'active' : '' }} {{ !$exists ? 'disabled' : '' }}">
                <span class="admin-menu-icon">{{ $item['icon'] }}</span>
                <span class="admin-menu-text">{{ $item['title'] }}</span>
                @if(!$exists)<span class="admin-soon">Soon</span>@endif
            </a>
        @endforeach
    </div>

    <a href="{{ \Illuminate\Support\Facades\Route::has('admin.committees.index') ? route('admin.committees.index') : '#' }}"
       class="admin-menu-item {{ request()->routeIs('admin.committees.*') ? 'active' : '' }} {{ !\Illuminate\Support\Facades\Route::has('admin.committees.index') ? 'disabled' : '' }}">
        <span class="admin-menu-icon">👥</span>
        <span class="admin-menu-text">Committee Management</span>
        @if(!\Illuminate\Support\Facades\Route::has('admin.committees.index'))<span class="admin-soon">Soon</span>@endif
    </a>

    <a href="{{ \Illuminate\Support\Facades\Route::has('admin.alumni.index') ? route('admin.alumni.index') : '#' }}"
       class="admin-menu-item {{ request()->routeIs('admin.alumni.*') ? 'active' : '' }} {{ !\Illuminate\Support\Facades\Route::has('admin.alumni.index') ? 'disabled' : '' }}">
        <span class="admin-menu-icon">👨‍🎓</span>
        <span class="admin-menu-text">Alumni Management</span>
        @if(!\Illuminate\Support\Facades\Route::has('admin.alumni.index'))<span class="admin-soon">Soon</span>@endif
    </a>

    <a href="{{ \Illuminate\Support\Facades\Route::has('admin.grievances.index') ? route('admin.grievances.index') : '#' }}"
       class="admin-menu-item {{ request()->routeIs('admin.grievances.*') ? 'active' : '' }} {{ !\Illuminate\Support\Facades\Route::has('admin.grievances.index') ? 'disabled' : '' }}">
        <span class="admin-menu-icon">💬</span>
        <span class="admin-menu-text">Grievance Management</span>
        @if(!\Illuminate\Support\Facades\Route::has('admin.grievances.index'))<span class="admin-soon">Soon</span>@endif
    </a>

    {{-- ================= ACADEMIC & STUDENTS ================= --}}
    <div class="admin-section-title">Academic & Students</div>

    <a href="{{ \Illuminate\Support\Facades\Route::has('admin.students.index') ? route('admin.students.index') : '#' }}"
       class="admin-menu-item {{ request()->routeIs('admin.students.index') ? 'active' : '' }} {{ !\Illuminate\Support\Facades\Route::has('admin.students.index') ? 'disabled' : '' }}">
        <span class="admin-menu-icon">🎓</span>
        <span class="admin-menu-text">Student Management</span>
        @if(!\Illuminate\Support\Facades\Route::has('admin.students.index'))<span class="admin-soon">Soon</span>@endif
    </a>

    {{-- ADMISSION ACCORDION --}}
    <button type="button"
            class="admin-menu-button {{ request()->routeIs('admin.admissions.*') ? 'active open' : '' }}"
            data-admin-accordion="admissionSubmenu">
        <span class="admin-menu-icon">📋</span>
        <span class="admin-menu-text">Admission Management</span>
        <span class="admin-menu-arrow">›</span>
    </button>

    <div class="admin-submenu {{ request()->routeIs('admin.admissions.*') ? 'open' : '' }}" id="admissionSubmenu">
        @foreach($admissionItems as $item)
            @php $exists = \Illuminate\Support\Facades\Route::has($item['route']); @endphp
            <a href="{{ $exists ? route($item['route']) : '#' }}"
               class="admin-menu-item {{ $exists && request()->routeIs($item['route']) ? 'active' : '' }} {{ !$exists ? 'disabled' : '' }}">
                <span class="admin-menu-icon">{{ $item['icon'] }}</span>
                <span class="admin-menu-text">{{ $item['title'] }}</span>
                @if(!$exists)<span class="admin-soon">Soon</span>@endif
            </a>
        @endforeach
    </div>

    <a href="{{ \Illuminate\Support\Facades\Route::has('admin.courses.index') ? route('admin.courses.index') : '#' }}"
       class="admin-menu-item {{ request()->routeIs('admin.courses.*') ? 'active' : '' }} {{ !\Illuminate\Support\Facades\Route::has('admin.courses.index') ? 'disabled' : '' }}">
        <span class="admin-menu-icon">📚</span>
        <span class="admin-menu-text">Courses / Programmes</span>
        @if(!\Illuminate\Support\Facades\Route::has('admin.courses.index'))<span class="admin-soon">Soon</span>@endif
    </a>

    <a href="{{ \Illuminate\Support\Facades\Route::has('admin.sessions.index') ? route('admin.sessions.index') : '#' }}"
       class="admin-menu-item {{ request()->routeIs('admin.sessions.*') ? 'active' : '' }} {{ !\Illuminate\Support\Facades\Route::has('admin.sessions.index') ? 'disabled' : '' }}">
        <span class="admin-menu-icon">🗓</span>
        <span class="admin-menu-text">Academic Sessions</span>
        @if(!\Illuminate\Support\Facades\Route::has('admin.sessions.index'))<span class="admin-soon">Soon</span>@endif
    </a>

    {{-- ================= FINANCE ================= --}}
    <div class="admin-section-title">Finance</div>

    <a href="{{ \Illuminate\Support\Facades\Route::has('admin.fees.index') ? route('admin.fees.index') : '#' }}"
       class="admin-menu-item {{ request()->routeIs('admin.fees.*') ? 'active' : '' }} {{ !\Illuminate\Support\Facades\Route::has('admin.fees.index') ? 'disabled' : '' }}">
        <span class="admin-menu-icon">💳</span>
        <span class="admin-menu-text">Fee Management</span>
        @if(!\Illuminate\Support\Facades\Route::has('admin.fees.index'))<span class="admin-soon">Soon</span>@endif
    </a>

    <a href="{{ \Illuminate\Support\Facades\Route::has('admin.fee.headwise') ? route('admin.fee.headwise') : '#' }}"
       class="admin-menu-item {{ request()->routeIs('admin.fee.headwise') ? 'active' : '' }} {{ !\Illuminate\Support\Facades\Route::has('admin.fee.headwise') ? 'disabled' : '' }}">
        <span class="admin-menu-icon">▤</span>
        <span class="admin-menu-text">Headwise Fee Report</span>
        @if(!\Illuminate\Support\Facades\Route::has('admin.fee.headwise'))<span class="admin-soon">Soon</span>@endif
    </a>

    {{-- ================= REPORTS ================= --}}
    <div class="admin-section-title">Reports</div>

    <a href="{{ \Illuminate\Support\Facades\Route::has('admin.leads.index') ? route('admin.leads.index') : '#' }}"
       class="admin-menu-item {{ request()->routeIs('admin.leads.*') ? 'active' : '' }} {{ !\Illuminate\Support\Facades\Route::has('admin.leads.index') ? 'disabled' : '' }}">
        <span class="admin-menu-icon">▤</span>
        <span class="admin-menu-text">Admission Lead Generation</span>
        @if(!\Illuminate\Support\Facades\Route::has('admin.leads.index'))<span class="admin-soon">Soon</span>@endif
    </a>

    <a href="{{ \Illuminate\Support\Facades\Route::has('admin.reports.initial-admission') ? route('admin.reports.initial-admission') : '#' }}"
       class="admin-menu-item {{ request()->routeIs('admin.reports.initial-admission') ? 'active' : '' }} {{ !\Illuminate\Support\Facades\Route::has('admin.reports.initial-admission') ? 'disabled' : '' }}">
        <span class="admin-menu-icon">▤</span>
        <span class="admin-menu-text">Initial Admission Report</span>
        @if(!\Illuminate\Support\Facades\Route::has('admin.reports.initial-admission'))<span class="admin-soon">Soon</span>@endif
    </a>

    <a href="{{ \Illuminate\Support\Facades\Route::has('admin.reports.index') ? route('admin.reports.index') : '#' }}"
       class="admin-menu-item {{ request()->routeIs('admin.reports.index') ? 'active' : '' }} {{ !\Illuminate\Support\Facades\Route::has('admin.reports.index') ? 'disabled' : '' }}">
        <span class="admin-menu-icon">📊</span>
        <span class="admin-menu-text">Reports Dashboard</span>
        @if(!\Illuminate\Support\Facades\Route::has('admin.reports.index'))<span class="admin-soon">Soon</span>@endif
    </a>

    {{-- ================= SYSTEM ================= --}}
    <div class="admin-section-title">System</div>

    <a href="{{ \Illuminate\Support\Facades\Route::has('admin.settings') ? route('admin.settings') : '#' }}"
       class="admin-menu-item {{ request()->routeIs('admin.settings') ? 'active' : '' }} {{ !\Illuminate\Support\Facades\Route::has('admin.settings') ? 'disabled' : '' }}">
        <span class="admin-menu-icon">⚙️</span>
        <span class="admin-menu-text">System Settings</span>
        @if(!\Illuminate\Support\Facades\Route::has('admin.settings'))<span class="admin-soon">Soon</span>@endif
    </a>

    <form action="{{ route('logout') }}" method="POST" class="admin-signout-form">
        @csrf
        <button type="submit" class="admin-menu-button">
            <span class="admin-menu-icon">🔒</span>
            <span class="admin-menu-text">Sign Out</span>
        </button>
    </form>

</aside>
