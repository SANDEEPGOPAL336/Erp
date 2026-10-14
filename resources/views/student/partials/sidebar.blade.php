{{-- =========================================================
     COMMON STUDENT SIDEBAR
     resources/views/student/partials/sidebar.blade.php
========================================================= --}}

<style>

    .student-sidebar-logo-area {
        text-align: center;
        padding: 20px 10px;
        border-bottom: 1px solid #aaa;
    }

    .student-sidebar-logo {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: auto;
        color: #40358f;
        font-weight: bold;
    }

    .student-sidebar-photo {
        width: 92px;
        height: 92px;
        border-radius: 50%;
        object-fit: cover;
        object-position: center;
        display: block;
        margin: 10px auto 5px;
        border: 3px solid #ffffff;
        box-shadow: 0 1px 5px rgba(0,0,0,.15);
        background: #ffffff;
    }

    .student-sidebar-photo-placeholder {
        width: 92px;
        height: 92px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        margin: 10px auto 5px;
        border: 1px solid #bbb;
        background: #ffffff;
        color: #777;
        font-size: 11px;
        line-height: 1.2;
    }

    .student-sidebar-small {
        display: block;
        margin-top: 8px;
        color: #555;
    }

    .student-sidebar-link {
        display: block;
        padding: 11px 12px;
        text-decoration: none;
        color: #222;
        font-size: 13px;
        border-left: 4px solid transparent;
    }

    .student-sidebar-link:hover {
        background: white;
    }

    .student-sidebar-link.active {
        background: white;
        border-left-color: #198754;
        color: #198754;
        font-weight: bold;
    }

    .student-sidebar-signout {
        border: 0;
        background: transparent;
        width: 100%;
        text-align: left;
        cursor: pointer;
        font-family: Arial, sans-serif;
    }

</style>


@php
    /*
    |--------------------------------------------------------------------------
    | Get the logged-in student's profile
    |--------------------------------------------------------------------------
    |
    | This does NOT depend on $profile being passed by the controller.
    | Therefore the photograph works on every student page.
    |
    */

    $studentSidebarProfile = auth()->user()->studentProfile;
@endphp


<aside class="sidebar" id="studentSidebar">

    {{-- =====================================================
         LOGO + STUDENT PHOTOGRAPH
    ====================================================== --}}

    <div class="student-sidebar-logo-area">

        <div class="student-sidebar-logo">
            COLLEGE
        </div>


        @if($studentSidebarProfile?->student_photo_path)

            <img
                src="{{ asset('storage/' . $studentSidebarProfile->student_photo_path) }}?v={{ optional($studentSidebarProfile->updated_at)->timestamp }}"
                alt="Student Photograph"
                class="student-sidebar-photo"
            >

        @else

            <div class="student-sidebar-photo-placeholder">
                👤
                <br>
                Student Photo
            </div>

        @endif


        <small class="student-sidebar-small">
            Student Portal
        </small>

    </div>


    {{-- =====================================================
         DASHBOARD
    ====================================================== --}}

    <a
        href="{{ route('student.dashboard') }}"
        class="student-sidebar-link
            {{ request()->routeIs('student.dashboard') ? 'active' : '' }}"
    >
        🏠 Dashboard
    </a>


    {{-- =====================================================
         COURSE / PROGRAMME
    ====================================================== --}}

    <a
        href="{{ route('student.admission.course') }}"
        class="student-sidebar-link
            {{ request()->routeIs('student.admission.course') ? 'active' : '' }}"
    >
        📚 Course / Programme
    </a>


    {{-- =====================================================
         PERSONAL INFORMATION
    ====================================================== --}}

    <a
        href="{{ route('student.personal') }}"
        class="student-sidebar-link
            {{ request()->routeIs('student.personal') ? 'active' : '' }}"
    >
        👤 Personal Information
    </a>


    {{-- =====================================================
         EDUCATION QUALIFICATIONS
    ====================================================== --}}

    <a
        href="{{ route('student.qualifications*') }}"
        class="student-sidebar-link
            {{ request()->routeIs('student.qualifications*') ? 'active' : '' }}"
    >
        🎓 Education Qualifications
    </a>


    {{-- =====================================================
         DOCUMENT UPLOAD
    ====================================================== --}}

    <a
        href="{{ route('student.documents') }}"
        class="student-sidebar-link
            {{ request()->routeIs('student.documents*') ? 'active' : '' }}"
    >
        📄 Document Upload
    </a>


    {{-- =====================================================
         REGISTRATION FORM
    ====================================================== --}}

    <a
        href="{{ route('student.registration.form') }}"
        class="student-sidebar-link
            {{ request()->routeIs('student.registration.form*') ? 'active' : '' }}"
    >
        📝 Registration Form
    </a>


    {{-- =====================================================
         FEE PAYMENT
         Not created yet
    ====================================================== --}}

    <a
        href="#"
        class="student-sidebar-link"
    >
        💰 Fee Payment
    </a>


    {{-- =====================================================
         SIGN OUT
    ====================================================== --}}

    <form
        method="POST"
        action="{{ route('logout') }}"
        style="margin:0;"
    >

        @csrf

        <button
            type="submit"
            class="student-sidebar-link student-sidebar-signout"
        >
            🔒 Sign Out
        </button>

    </form>

</aside>