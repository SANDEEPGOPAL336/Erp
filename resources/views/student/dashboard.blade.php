<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Student Dashboard - College ERP</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f4f7;
            color: #222;
        }

        /* TOP BAR */
        .topbar {
            height: 60px;
            background: #40358f;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .topbar strong {
            font-size: 16px;
        }

        .mobile-menu-btn {
            display: none;
            border: 0;
            background: transparent;
            color: white;
            font-size: 25px;
            cursor: pointer;
        }

        .topbar-user {
            font-size: 13px;
            max-width: 45%;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* SIDEBAR */
        .sidebar {
            position: fixed;
            top: 60px;
            left: 0;
            bottom: 0;
            width: 220px;
            background: #d0d0d0;
            overflow-y: auto;
            z-index: 1100;
            transition: transform .2s ease;
        }

        .logo-area {
            text-align: center;
            padding: 20px 10px;
            border-bottom: 1px solid #aaa;
        }

        .student-profile-photo,
        .student-profile-placeholder {
            width: 92px;
            height: 92px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 10px auto 5px;
            border: 3px solid white;
            background: white;
            object-fit: cover;
            object-position: center;
        }

        .student-profile-placeholder {
            color: #40358f;
            font-size: 12px;
            text-align: center;
            border: 1px solid #bbb;
        }

        .logo-area small {
            display: block;
            margin-top: 8px;
            color: #555;
        }

        .menu-link {
            display: block;
            padding: 11px 12px;
            text-decoration: none;
            color: #222;
            font-size: 13px;
            border-left: 4px solid transparent;
        }

        .menu-link:hover {
            background: white;
        }

        .menu-link.active {
            background: white;
            border-left-color: #198754;
            color: #198754;
            font-weight: bold;
        }

        .signout-button {
            border: 0;
            background: transparent;
            width: 100%;
            text-align: left;
            cursor: pointer;
            font-family: Arial, sans-serif;
        }

        .sidebar-overlay {
            display: none;
        }

        /* MAIN CONTENT */
        .content {
            margin-left: 220px;
            padding: 85px 25px 30px;
            min-height: 100vh;
        }

        .page-title {
            font-size: 22px;
            margin-bottom: 20px;
        }

        /* ALERTS */
        .alert {
            padding: 12px 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 13px;
            line-height: 1.5;
        }

        .alert-success {
            background: #d1e7dd;
            color: #0f5132;
            border-left: 4px solid #198754;
        }

        .alert-danger {
            background: #f8d7da;
            color: #842029;
            border-left: 4px solid #dc3545;
        }

        .alert-warning {
            background: #fff3cd;
            color: #664d03;
            border-left: 4px solid #ffc107;
        }

        /* WELCOME */
        .welcome {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,.08);
        }

        .welcome h3 {
            margin-top: 0;
            margin-bottom: 8px;
        }

        .welcome p {
            margin: 6px 0;
        }

        /* STEP CARDS */
        .steps {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 15px;
        }

        .step {
            display: block;
            background: white;
            border-radius: 8px;
            padding: 20px;
            min-height: 150px;
            box-shadow: 0 2px 8px rgba(0,0,0,.08);
            border-left: 5px solid #40358f;
            text-decoration: none;
            color: inherit;
            transition: transform .15s ease, box-shadow .15s ease;
        }

        .step:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,.12);
        }

        .step-number {
            color: #40358f;
            font-weight: bold;
            font-size: 13px;
        }

        .step h3 {
            font-size: 16px;
            margin-top: 10px;
            margin-bottom: 8px;
        }

        .step p {
            margin: 0;
            line-height: 1.5;
            font-size: 13px;
            color: #555;
        }

        .step.done {
            border-left-color: #198754;
        }

        .step.done .step-number {
            color: #198754;
        }

        .step.pending {
            border-left-color: #dc3545;
        }

        .step.pending .step-number {
            color: #dc3545;
        }

        .status-text {
            margin-top: 10px;
            font-size: 11px;
            font-weight: bold;
        }

        /* ADMISSION STATUS */
        .status-box {
            background: white;
            margin-top: 25px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,.08);
            overflow-x: auto;
        }

        .status-box h3 {
            margin-top: 0;
        }

        table {
            width: 100%;
            min-width: 450px;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
            font-size: 13px;
        }

        th {
            background: #40358f;
            color: white;
            width: 35%;
        }

        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 4px;
            background: #ffc107;
            color: black;
        }

        .badge-approved {
            background: #198754;
            color: white;
        }

        .badge-rejected {
            background: #dc3545;
            color: white;
        }

        .badge-submitted {
            background: #ffc107;
            color: black;
        }

        .rejection-reason {
            margin-top: 10px;
            padding: 12px;
            background: #f8d7da;
            color: #842029;
            border-radius: 5px;
        }

        /* TABLET */
        @media (max-width: 1000px) {
            .steps {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        /* MOBILE */
        @media (max-width: 800px) {
            .mobile-menu-btn {
                display: inline-block;
            }

            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .sidebar-overlay.show {
                display: block;
                position: fixed;
                top: 60px;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0,0,0,.35);
                z-index: 1050;
            }

            .content {
                margin-left: 0;
                padding: 82px 18px 25px;
            }

            .steps {
                grid-template-columns: 1fr;
            }

            .step {
                min-height: 125px;
            }
        }

        @media (max-width: 500px) {
            .topbar {
                height: 56px;
                padding: 0 10px;
            }

            .topbar strong {
                font-size: 14px;
            }

            .topbar-user {
                font-size: 12px;
                max-width: 38%;
            }

            .sidebar {
                top: 56px;
                width: min(280px, 88vw);
            }

            .sidebar-overlay.show {
                top: 56px;
            }

            .content {
                padding: 75px 12px 20px;
            }

            .page-title {
                font-size: 20px;
            }

            .welcome,
            .status-box {
                padding: 15px;
            }

            .step {
                padding: 16px;
            }
        }
    </style>
</head>

<body>

<header class="topbar">

    <div class="topbar-left">
        <button
            type="button"
            class="mobile-menu-btn"
            id="mobileMenuBtn"
            aria-label="Open student menu"
            aria-expanded="false"
        >
            ☰
        </button>

        <strong>Student Panel</strong>
    </div>

    <span class="topbar-user">
        {{ auth()->user()->name }}
    </span>

</header>

<div
    class="sidebar-overlay"
    id="sidebarOverlay"
></div>

<aside class="sidebar" id="studentSidebar">

    <div class="logo-area">

        @if($profile && $profile->student_photo_path)
            <img
                src="{{ asset('storage/' . $profile->student_photo_path) }}?v={{ $profile->updated_at?->timestamp ?? time() }}"
                alt="Student Photograph"
                class="student-profile-photo"
            >
        @else
            <div class="student-profile-placeholder">
                COLLEGE
            </div>
        @endif

        <small>Student Portal</small>

    </div>

    <a href="{{ route('student.dashboard') }}"
       class="menu-link active">
        🏠 Dashboard
    </a>

    <a href="{{ route('student.admission.course') }}"
       class="menu-link">
        📚 Course / Programme
    </a>

    <a href="{{ route('student.personal') }}"
       class="menu-link">
        👤 Personal Information
    </a>

    <a href="{{ route('student.qualifications') }}"
       class="menu-link">
        🎓 Educational Qualifications
    </a>

    <a href="{{ route('student.documents') }}"
       class="menu-link">
        📄 Document Upload
    </a>

    <a href="{{ route('student.registration.form') }}"
       class="menu-link">
        📝 Final Registration Form
    </a>

    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <button type="submit"
                class="menu-link signout-button">
            🔒 Sign Out
        </button>
    </form>

</aside>

<main class="content">

    <div class="page-title">
        🎨 Dashboard
    </div>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- ERROR MESSAGE --}}
    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    {{-- REJECTION MESSAGE --}}
    @if($application && $application->status === 'rejected')
        <div class="alert alert-danger">
            <strong>Application Rejected</strong>
            <br>
            Your application needs correction before resubmission.

            <div class="rejection-reason">
                <strong>Reason given by teacher:</strong>
                <br>
                {{ $application->review_remarks ?? 'No rejection reason was provided.' }}

                @if($application->reviewed_at)
                    <br><br>
                    <strong>Reviewed on:</strong>
                    {{ $application->reviewed_at->format('d-m-Y h:i A') }}
                @endif
            </div>
        </div>
    @endif

    {{-- SUBMISSION MESSAGE --}}
    @if($application && $application->status === 'submitted')
        <div class="alert alert-success">
            Your admission application has been submitted successfully
            and sent to the Unit Teacher for verification.
        </div>
    @endif

    {{-- APPROVED MESSAGE --}}
    @if($application && $application->status === 'approved')
        <div class="alert alert-success">
            <strong>Application Approved!</strong>
            Your application has been approved by the Unit Teacher.
            The submitted information is now locked.
        </div>
    @endif

    {{-- WELCOME --}}
    <div class="welcome">

        <h3>
            Welcome, {{ auth()->user()->name }}
        </h3>

        <p>College ERP Student Portal</p>

        @if($application)
            <p>
                Application No:
                <strong>
                    {{ $application->application_no ?? '-' }}
                </strong>
            </p>
        @endif

        @if($profile && $profile->signature_path)
            <div style="margin-top:12px;">
                <strong>Student Signature</strong>
                <br>
                <img
                    src="{{ asset('storage/' . $profile->signature_path) }}?v={{ $profile->updated_at?->timestamp ?? time() }}"
                    alt="Student Signature"
                    style="width:180px;height:60px;object-fit:contain;margin-top:5px;"
                >
            </div>
        @endif

    </div>

    {{-- CALCULATE STEP COMPLETION --}}
    @php

        $personalCompleted =
            $profile &&
            !empty($profile->date_of_birth) &&
            !empty($profile->gender) &&
            !empty($profile->category) &&
            !empty($profile->father_name) &&
            !empty($profile->mother_name) &&
            !empty($profile->student_photo_path) &&
            !empty($profile->signature_path);

        $qualificationCount = 0;

        if ($profile) {
            $qualificationCount = $profile
                ->qualifications()
                ->where('is_active', true)
                ->count();
        }

        $documentCount = 0;

        if ($profile) {
            $documentCount = $profile
                ->documents()
                ->where('is_active', true)
                ->count();
        }

        $finalCompleted =
            $application &&
            in_array($application->status, ['submitted', 'approved']);

    @endphp

    {{-- ADMISSION STEPS --}}
    <div class="steps">

        {{-- STEP 1 --}}
        <a href="{{ route('student.admission.course') }}"
           class="step {{ $application && $application->course_id ? 'done' : 'pending' }}">

            <div class="step-number">STEP 1</div>

            <h3>Course / Programme Selection</h3>

            <p>Select your course or programme for admission.</p>

            @if($application && $application->course_id)
                <div class="status-text" style="color:#198754;">
                    ✓ COMPLETED
                </div>
            @else
                <div class="status-text" style="color:#dc3545;">
                    PENDING
                </div>
            @endif

        </a>

        {{-- STEP 2 --}}
        <a href="{{ route('student.personal') }}"
           class="step {{ $personalCompleted ? 'done' : 'pending' }}">

            <div class="step-number">STEP 2</div>

            <h3>Personal Information</h3>

            <p>
                Enter personal, parent and address details.
                Upload your photograph and signature.
            </p>

            @if($personalCompleted)
                <div class="status-text" style="color:#198754;">
                    ✓ COMPLETED
                </div>
            @else
                <div class="status-text" style="color:#dc3545;">
                    PENDING — COMPLETE DETAILS, PHOTO AND SIGNATURE
                </div>
            @endif

        </a>

        {{-- STEP 3 --}}
        <a href="{{ route('student.qualifications') }}"
           class="step {{ $qualificationCount > 0 ? 'done' : 'pending' }}">

            <div class="step-number">STEP 3</div>

            <h3>Educational Qualifications</h3>

            <p>Add your 10th, 12th, graduation and other qualification details.</p>

            @if($qualificationCount > 0)
                <div class="status-text" style="color:#198754;">
                    ✓ {{ $qualificationCount }} RECORD(S) ADDED
                </div>
            @else
                <div class="status-text" style="color:#dc3545;">
                    PENDING
                </div>
            @endif

        </a>

        {{-- STEP 4 --}}
        <a href="{{ route('student.documents') }}"
           class="step {{ $documentCount > 0 ? 'done' : 'pending' }}">

            <div class="step-number">STEP 4</div>

            <h3>Document Upload</h3>

            <p>Upload the required documents and certificates.</p>

            @if($documentCount > 0)
                <div class="status-text" style="color:#198754;">
                    ✓ {{ $documentCount }} DOCUMENT(S) ADDED
                </div>
            @else
                <div class="status-text" style="color:#dc3545;">
                    PENDING
                </div>
            @endif

        </a>

        {{-- STEP 5 --}}
        <a href="{{ route('student.registration.form') }}"
           class="step {{ $finalCompleted ? 'done' : 'pending' }}">

            <div class="step-number">STEP 5</div>

            <h3>Final Registration Form</h3>

            <p>Preview, print and submit your final application.</p>

            @if($application && $application->status === 'approved')
                <div class="status-text" style="color:#198754;">
                    ✓ APPROVED &amp; LOCKED
                </div>
            @elseif($application && $application->status === 'submitted')
                <div class="status-text" style="color:#198754;">
                    ✓ COMPLETED / SUBMITTED
                </div>
            @elseif($application && $application->status === 'rejected')
                <div class="status-text" style="color:#dc3545;">
                    RE-SUBMISSION REQUIRED
                </div>
            @else
                <div class="status-text" style="color:#dc3545;">
                    PENDING
                </div>
            @endif

        </a>

    </div>

    {{-- ADMISSION STATUS --}}
    @if($application)

        <div class="status-box">

            <h3>Admission Status</h3>

            <table>

                <tr>
                    <th>Registration Number</th>
                    <td>
                        {{ $profile->registration_no ?? '-' }}
                    </td>
                </tr>

                <tr>
                    <th>Application Number</th>
                    <td>
                        {{ $application->application_no ?? '-' }}
                    </td>
                </tr>

                <tr>
                    <th>Selected Course</th>
                    <td>
                        {{ $application->course->name ?? '-' }}
                    </td>
                </tr>

                <tr>
                    <th>Status</th>
                    <td>
                        @if($application->status === 'approved')
                            <span class="badge badge-approved">Approved</span>
                        @elseif($application->status === 'rejected')
                            <span class="badge badge-rejected">Rejected</span>
                        @elseif($application->status === 'submitted')
                            <span class="badge badge-submitted">Submitted</span>
                        @else
                            <span class="badge">
                                {{ ucfirst(str_replace('_', ' ', $application->status)) }}
                            </span>
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>Admission Type</th>
                    <td>
                        {{ $application->admission_type ?? '-' }}
                    </td>
                </tr>

                <tr>
                    <th>Submitted Date</th>
                    <td>
                        @if($application->submitted_at)
                            {{ $application->submitted_at }}
                        @else
                            Not submitted
                        @endif
                    </td>
                </tr>

            </table>

        </div>

    @else

        <div class="status-box">
            <h3>Admission Application Not Found</h3>
            <p>Please contact the college administration.</p>
        </div>

    @endif

</main>

<script>
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const studentSidebar = document.getElementById('studentSidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    function openStudentMenu() {
        studentSidebar.classList.add('open');
        sidebarOverlay.classList.add('show');
        mobileMenuBtn.setAttribute('aria-expanded', 'true');
    }

    function closeStudentMenu() {
        studentSidebar.classList.remove('open');
        sidebarOverlay.classList.remove('show');
        mobileMenuBtn.setAttribute('aria-expanded', 'false');
    }

    mobileMenuBtn.addEventListener('click', function () {
        if (studentSidebar.classList.contains('open')) {
            closeStudentMenu();
        } else {
            openStudentMenu();
        }
    });

    sidebarOverlay.addEventListener('click', closeStudentMenu);

    document.querySelectorAll('#studentSidebar a').forEach(function (link) {
        link.addEventListener('click', function () {
            if (window.innerWidth <= 800) {
                closeStudentMenu();
            }
        });
    });

    window.addEventListener('resize', function () {
        if (window.innerWidth > 800) {
            closeStudentMenu();
        }
    });
</script>

</body>
</html>