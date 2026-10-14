<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Registration Form - College ERP
    </title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;

            font-family: Arial, Helvetica, sans-serif;

            background: #f4f5f9;

            color: #111;
        }


        /* =====================================================
           TOP BAR
        ===================================================== */

        .topbar {

            position: fixed;

            top: 0;
            left: 0;
            right: 0;

            height: 62px;

            background: #40358f;

            color: white;

            display: flex;

            align-items: center;

            justify-content: space-between;

            padding: 0 22px;

            z-index: 1000;

        }


        .topbar-title {

            font-size: 18px;

            font-weight: bold;

        }


        /* =====================================================
           SIDEBAR
        ===================================================== */

        .sidebar {

            position: fixed;

            top: 62px;

            left: 0;

            bottom: 0;

            width: 230px;

            background: #cecece;

            overflow-y: auto;

            z-index: 900;

            border-right: 1px solid #aaa;

        }


        .logo-area {

            text-align: center;

            padding: 20px 10px;

            border-bottom: 1px solid #aaa;

        }


        .logo-circle {

            width: 80px;

            height: 80px;

            border-radius: 50%;

            background: white;

            display: flex;

            align-items: center;

            justify-content: center;

            margin: 0 auto 10px;

            color: #40358f;

            font-size: 12px;

            font-weight: bold;

            border: 2px solid #40358f;

        }


        .logo-area small {

            font-size: 11px;

            color: #444;

        }


        .menu-link {

            display: block;

            width: 100%;

            padding: 12px 14px;

            text-decoration: none;

            color: #222;

            font-size: 13px;

            border: 0;

            background: transparent;

            text-align: left;

            cursor: pointer;

        }


        .menu-link:hover {

            background: white;

        }


        .menu-link.active {

            background: white;

            color: #40358f;

            font-weight: bold;

            border-left: 4px solid #40358f;

            padding-left: 10px;

        }


        /* =====================================================
           CONTENT
        ===================================================== */

        .content {

            margin-left: 230px;

            padding: 90px 30px 50px;

            min-height: 100vh;

        }


        .page-title {

            font-size: 23px;

            font-weight: bold;

            margin-bottom: 20px;

        }


        .success {

            max-width: 1000px;

            margin: 0 auto 20px;

            padding: 12px 15px;

            background: #d1e7dd;

            color: #0f5132;

            border: 1px solid #badbcc;

            border-radius: 5px;

        }


        .error {

            max-width: 1000px;

            margin: 0 auto 20px;

            padding: 12px 15px;

            background: #f8d7da;

            color: #842029;

            border: 1px solid #f5c2c7;

            border-radius: 5px;

        }


        /* =====================================================
           FORM
        ===================================================== */

        .form-wrapper {

            max-width: 1050px;

            margin: auto;

            background: white;

            border: 1px solid #cfcfcf;

        }


        .college-header {

            text-align: center;

            padding: 20px;

            border-bottom: 1px solid #ccc;

        }


        .college-logo {

            width: 80px;

            height: 80px;

            border-radius: 50%;

            margin: 0 auto 10px;

            background: #f4f4f4;

            display: flex;

            align-items: center;

            justify-content: center;

            color: #40358f;

            font-weight: bold;

            border: 2px solid #40358f;

        }


        .college-header h2 {

            margin: 5px 0;

            color: #d71920;

            font-size: 20px;

        }


        .college-header p {

            margin: 5px 0;

            font-size: 12px;

        }


        .section-bar {

            background: #40358f;

            color: white;

            padding: 8px 10px;

            font-size: 13px;

            font-weight: bold;

        }


        table {

            width: 100%;

            border-collapse: collapse;

        }


        th {

            background: #eeeeee;

            font-weight: bold;

        }


        th,
        td {

            border: 1px solid #d8d8d8;

            padding: 8px;

            font-size: 12px;

            vertical-align: top;

            text-align: left;

        }


        .label {

            width: 19%;

            font-weight: bold;

            background: #fafafa;

        }


        .photo-cell {

            width: 120px;

            height: 130px;

            text-align: center;

            vertical-align: middle;

        }


        .photo-placeholder {

            width: 85px;

            height: 105px;

            border: 1px solid #ccc;

            margin: auto;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 10px;

            color: #777;

        }


        /* =====================================================
           STUDENT PHOTO & SIGNATURE
        ===================================================== */

        .student-photo {

            width: 85px;

            height: 105px;

            object-fit: cover;

            display: block;

            margin: auto;

            border: 1px solid #ccc;

        }


        .student-signature {

            width: 180px;

            height: 70px;

            object-fit: contain;

            display: block;

            margin: auto;

            border: 1px solid #ccc;

        }


        .subsection {

            margin-top: 20px;

        }


        /* =====================================================
           DECLARATION
        ===================================================== */

        .declaration {

            padding: 18px;

            font-size: 13px;

            line-height: 1.6;

        }


        .declaration label {

            display: flex;

            gap: 10px;

            align-items: flex-start;

            font-weight: normal;

        }


        .declaration input {

            margin-top: 3px;

        }


        /* =====================================================
           BUTTONS
        ===================================================== */

        .actions {

            max-width: 1050px;

            margin: 20px auto;

            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 10px;

        }


        .btn {

            padding: 10px 20px;

            border: none;

            border-radius: 5px;

            text-decoration: none;

            display: inline-block;

            cursor: pointer;

            font-size: 13px;

        }


        .btn-back {

            background: #ffc107;

            color: #222;

        }


        .btn-print {

            background: #6c757d;

            color: white;

        }


        .btn-submit {

            background: #198754;

            color: white;

        }


        /* =====================================================
           MOBILE
        ===================================================== */

        @media(max-width: 800px) {

            .sidebar {

                width: 180px;

            }


            .content {

                margin-left: 180px;

                padding-left: 15px;

                padding-right: 15px;

            }


            .topbar-title {

                font-size: 15px;

            }


            th,
            td {

                font-size: 11px;

            }

        }


        @media(max-width: 600px) {

            .sidebar {

                display: none;

            }


            .content {

                margin-left: 0;

            }


            .actions {

                flex-direction: column;

                align-items: stretch;

            }


            .btn {

                text-align: center;

            }

        }


        /* =====================================================
           PRINT
        ===================================================== */

        @media print {

            .topbar,
            .sidebar,
            .actions {

                display: none !important;

            }


            .content {

                margin: 0;

                padding: 0;

            }


            body {

                background: white;

            }


            .form-wrapper {

                border: none;

                max-width: 100%;

            }

        }

    </style>

</head>


<body>


<!-- =========================================================
     TOP BAR
========================================================= -->

<header class="topbar">

    <div class="topbar-title">

        Student Panel

    </div>


    <div>

        {{ auth()->user()->name }}

    </div>

</header>


<!-- =========================================================
     SIDEBAR
========================================================= -->

<aside class="sidebar">


    <div class="logo-area">

        <div class="logo-circle">
            COLLEGE
        </div>

        <small>
            Student Portal
        </small>

    </div>


    <a
        href="{{ route('student.dashboard') }}"
        class="menu-link"
    >
        🏠 Dashboard
    </a>


    <a
        href="{{ route('student.admission.course') }}"
        class="menu-link"
    >
        📚 Course / Programme
    </a>


    <a
        href="{{ route('student.personal') }}"
        class="menu-link"
    >
        👤 Personal Information
    </a>


    <a
        href="{{ route('student.qualifications') }}"
        class="menu-link"
    >
        🎓 Education Qualifications
    </a>


    <a
        href="{{ route('student.documents') }}"
        class="menu-link"
    >
        📄 Document Upload
    </a>


    <a
        href="{{ route('student.registration.form') }}"
        class="menu-link active"
    >
        📝 Registration Form
    </a>


    <form
        method="POST"
        action="{{ route('logout') }}"
        style="margin:0;"
    >

        @csrf

        <button
            type="submit"
            class="menu-link"
        >
            🔒 Sign Out
        </button>

    </form>


</aside>


<!-- =========================================================
     MAIN CONTENT
========================================================= -->

<main class="content">


    <div class="page-title">

        Registration Form

    </div>


    <!-- SUCCESS -->

    @if(session('success'))

        <div class="success">

            {{ session('success') }}

        </div>

    @endif


    <!-- ERRORS -->

    @if($errors->any())

        <div class="error">

            <strong>
                Please correct the following:
            </strong>

            <ul>

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    <!-- =====================================================
         FORM PREVIEW
    ====================================================== -->

    <div class="form-wrapper">


        <!-- COLLEGE HEADER -->

        <div class="college-header">

            <div class="college-logo">
                COLLEGE
            </div>

            <h2>
                YOUR COLLEGE NAME
            </h2>

            <p>
                Academic Session:
                {{ $application->session?->name ?? '2026-27' }}
            </p>

            <p>
                Admission Application Form
            </p>

        </div>


        <!-- COURSE -->

        <div class="section-bar">

            ADMISSION IN:

            {{ $application->course?->name ?? '-' }}

            @if($application->semester)

                &nbsp; | &nbsp;

                Semester:

                {{ $application->semester->name }}

            @endif

        </div>


        <table>

            {{-- =================================================
                 STUDENT PHOTOGRAPH & SIGNATURE
            ================================================== --}}

            <tr>

                <td class="label">
                    Student Photograph
                </td>

                <td class="photo-cell">

                    @if($profile?->student_photo_path)

                        <img
                            src="{{ asset('storage/' . $profile->student_photo_path) }}?v={{ $profile->updated_at?->timestamp ?? time() }}"
                            alt="Student Photograph"
                            class="student-photo"
                        >

                    @else

                        <div class="photo-placeholder">
                            No Photograph
                        </div>

                    @endif

                </td>


                <td class="label">
                    Student Signature
                </td>

                <td>

                    @if($profile?->signature_path)

                        <img
                            src="{{ asset('storage/' . $profile->signature_path) }}?v={{ $profile->updated_at?->timestamp ?? time() }}"
                            alt="Student Signature"
                            class="student-signature"
                        >

                    @else

                        <div
                            style="
                                width:180px;
                                height:70px;
                                border:1px dashed #aaa;
                                display:flex;
                                align-items:center;
                                justify-content:center;
                                text-align:center;
                                color:#777;
                                margin:auto;
                                font-size:10px;
                            "
                        >
                            No Signature
                        </div>

                    @endif

                </td>

            </tr>


            <tr>

                <td class="label">
                    Student Name
                </td>

                <td>
                    {{ auth()->user()->name }}
                </td>

                <td class="label">
                    Registration ID
                </td>

                <td>
                    {{ $profile->registration_no ?? '-' }}
                </td>

            </tr>


            <tr>

                <td class="label">
                    Application No.
                </td>

                <td>
                    {{ $application->application_no }}
                </td>

                <td class="label">
                    Admission Type
                </td>

                <td>
                    {{ $application->admission_type }}
                </td>

            </tr>


            <tr>

                <td class="label">
                    Date of Birth
                </td>

                <td>

                    @if($profile->date_of_birth)

                        {{ $profile->date_of_birth->format('d-m-Y') }}

                    @else

                        -

                    @endif

                </td>


                <td class="label">
                    Gender
                </td>

                <td>
                    {{ $profile->gender ?? '-' }}
                </td>

            </tr>


            <tr>

                <td class="label">
                    Aadhaar No
                </td>

                <td>
                    {{ $profile->aadhaar_no ?? '-' }}
                </td>


                <td class="label">
                    Contact No
                </td>

                <td>
                    {{ auth()->user()->phone ?? '-' }}
                </td>

            </tr>


            <tr>

                <td class="label">
                    Father's Name
                </td>

                <td>
                    {{ $profile->father_name ?? '-' }}
                </td>


                <td class="label">
                    Father's Contact
                </td>

                <td>
                    {{ $profile->father_mobile ?? '-' }}
                </td>

            </tr>


            <tr>

                <td class="label">
                    Mother's Name
                </td>

                <td>
                    {{ $profile->mother_name ?? '-' }}
                </td>


                <td class="label">
                    Mother's Contact
                </td>

                <td>
                    {{ $profile->mother_mobile ?? '-' }}
                </td>

            </tr>


            <tr>

                <td class="label">
                    Alternate / WhatsApp No.
                </td>

                <td colspan="3">
                    {{ $profile->alternate_mobile ?? '-' }}
                </td>

            </tr>

        </table>


        <!-- =================================================
             PERMANENT ADDRESS
        ================================================== -->

        <div class="section-bar">

            PERMANENT ADDRESS

        </div>


        <table>

            <tr>

                <td class="label">
                    Address
                </td>

                <td colspan="3">
                    {{ $profile->permanent_address ?? '-' }}
                </td>

            </tr>


            <tr>

                <td class="label">
                    Post Office
                </td>

                <td>
                    {{ $profile->permanent_post_office ?? '-' }}
                </td>

                <td class="label">
                    Tehsil
                </td>

                <td>
                    {{ $profile->permanent_tehsil ?? '-' }}
                </td>

            </tr>


            <tr>

                <td class="label">
                    District
                </td>

                <td>
                    {{ $profile->permanent_district ?? '-' }}
                </td>

                <td class="label">
                    State
                </td>

                <td>
                    {{ $profile->permanent_state ?? '-' }}
                </td>

            </tr>


            <tr>

                <td class="label">
                    Country
                </td>

                <td>
                    {{ $profile->permanent_country ?? '-' }}
                </td>

                <td class="label">
                    PIN Code
                </td>

                <td>
                    {{ $profile->permanent_pin_code ?? '-' }}
                </td>

            </tr>

        </table>


        <!-- =================================================
             CORRESPONDENCE ADDRESS
        ================================================== -->

        <div class="section-bar">

            CORRESPONDENCE ADDRESS

        </div>


        <table>

            <tr>

                <td class="label">
                    Address
                </td>

                <td colspan="3">
                    {{ $profile->correspondence_address ?? '-' }}
                </td>

            </tr>


            <tr>

                <td class="label">
                    Post Office
                </td>

                <td>
                    {{ $profile->correspondence_post_office ?? '-' }}
                </td>

                <td class="label">
                    Tehsil
                </td>

                <td>
                    {{ $profile->correspondence_tehsil ?? '-' }}
                </td>

            </tr>


            <tr>

                <td class="label">
                    District
                </td>

                <td>
                    {{ $profile->correspondence_district ?? '-' }}
                </td>

                <td class="label">
                    State
                </td>

                <td>
                    {{ $profile->correspondence_state ?? '-' }}
                </td>

            </tr>


            <tr>

                <td class="label">
                    Country
                </td>

                <td>
                    {{ $profile->correspondence_country ?? '-' }}
                </td>

                <td class="label">
                    PIN Code
                </td>

                <td>
                    {{ $profile->correspondence_pin_code ?? '-' }}
                </td>

            </tr>

        </table>


        <!-- =================================================
             OTHER DETAILS
        ================================================== -->

        <div class="section-bar">

            OTHER DETAILS

        </div>


        <table>

            <tr>

                <td class="label">
                    Email
                </td>

                <td colspan="3">
                    {{ auth()->user()->email }}
                </td>

            </tr>


            <tr>

                <td class="label">
                    Marital Status
                </td>

                <td>
                    {{ $profile->marital_status ?? '-' }}
                </td>

                <td class="label">
                    Blood Group
                </td>

                <td>
                    {{ $profile->blood_group ?? '-' }}
                </td>

            </tr>


            <tr>

                <td class="label">
                    Nationality
                </td>

                <td>
                    {{ $profile->nationality ?? '-' }}
                </td>

                <td class="label">
                    Religion
                </td>

                <td>
                    {{ $profile->religion ?? '-' }}
                </td>

            </tr>


            <tr>

                <td class="label">
                    Category
                </td>

                <td>
                    {{ $profile->category ?? '-' }}
                </td>

                <td class="label">
                    Sub-Category
                </td>

                <td>
                    {{ $profile->sub_category ?? '-' }}
                </td>

            </tr>


            <tr>

                <td class="label">
                    IRDP / BPL
                </td>

                <td>
                    {{ $profile->irdp_bpl ? 'Yes' : 'No' }}
                </td>

                <td class="label">
                    Sports
                </td>

                <td>
                    {{ $profile->sports_quota ? 'Yes' : 'No' }}
                </td>

            </tr>


            <tr>

                <td class="label">
                    Himachali Bonafide
                </td>

                <td>
                    {{ $profile->himachali_bonafide ? 'Yes' : 'No' }}
                </td>

                <td class="label">
                    Cultural Quota
                </td>

                <td>
                    {{ $profile->cultural_quota ? 'Yes' : 'No' }}
                </td>

            </tr>


            <tr>

                <td class="label">
                    Minority Region
                </td>

                <td>
                    {{ $profile->minority_region ? 'Yes' : 'No' }}
                </td>

                <td class="label">
                    Physically Challenged
                </td>

                <td>
                    {{ $profile->physically_challenged ? 'Yes' : 'No' }}
                </td>

            </tr>


            <tr>

                <td class="label">
                    Gap After 12th
                </td>

                <td>
                    {{ $profile->gap_after_12th ? 'Yes' : 'No' }}
                </td>

                <td class="label">
                    Single Girl Child
                </td>

                <td>
                    {{ $profile->single_girl_child ? 'Yes' : 'No' }}
                </td>

            </tr>


            <tr>

                <td class="label">
                    NCC
                </td>

                <td>
                    {{ $profile->ncc ? 'Yes' : 'No' }}
                </td>

                <td class="label">
                    NSS
                </td>

                <td>
                    {{ $profile->nss ? 'Yes' : 'No' }}
                </td>

            </tr>


            <tr>

                <td class="label">
                    Related Student
                </td>

                <td>
                    {{ $profile->related_student ? 'Yes' : 'No' }}
                </td>

                <td class="label">
                    Serious Illness
                </td>

                <td>
                    {{ $profile->serious_illness ? 'Yes' : 'No' }}
                </td>

            </tr>


            <tr>

                <td class="label">
                    Ever Punished
                </td>

                <td colspan="3">
                    {{ $profile->punished ? 'Yes' : 'No' }}
                </td>

            </tr>


            <tr>

                <td class="label">
                    Sports / Cultural Distinction
                </td>

                <td colspan="3">
                    {{ $profile->sports_cultural_distinction ? 'Yes' : 'No' }}
                </td>

            </tr>

        </table>


        <!-- =================================================
             QUALIFICATIONS
        ================================================== -->

        <div class="section-bar">

            QUALIFICATIONS

        </div>


        <table>

            <thead>

                <tr>

                    <th>
                        S.No.
                    </th>

                    <th>
                        Exam Passed
                    </th>

                    <th>
                        University / Board
                    </th>

                    <th>
                        Roll No
                    </th>

                    <th>
                        Passing Year
                    </th>

                    <th>
                        Marks / CGPA
                    </th>

                    <th>
                        Percentage
                    </th>

                    <th>
                        Subjects / Stream
                    </th>

                </tr>

            </thead>


            <tbody>

            @forelse(
                $qualifications
                as $key => $qualification
            )

                <tr>

                    <td>
                        {{ $key + 1 }}
                    </td>

                    <td>
                        {{ $qualification->qualification_name }}
                    </td>

                    <td>
                        {{ $qualification->university_board }}
                    </td>

                    <td>
                        {{ $qualification->board_roll_no }}
                    </td>

                    <td>
                        {{ $qualification->passing_year }}
                    </td>

                    <td>

                        {{ $qualification->obtained_marks }}

                        /

                        {{ $qualification->total_marks }}

                    </td>

                    <td>
                        {{ number_format(
                            (float) $qualification->percentage,
                            2
                        ) }}
                    </td>

                    <td>
                        {{ $qualification->subjects_stream }}
                    </td>

                </tr>

            @empty

                <tr>

                    <td
                        colspan="8"
                        style="text-align:center;"
                    >
                        NO RECORD FOUND
                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>


        <!-- =================================================
             DOCUMENTS
        ================================================== -->

        <div class="section-bar">

            ATTACHED CERTIFICATES

        </div>


        <table>

            <thead>

                <tr>

                    <th>
                        S.No.
                    </th>

                    <th>
                        Document Name
                    </th>

                    <th>
                        File
                    </th>

                </tr>

            </thead>


            <tbody>

            @forelse(
                $documents
                as $key => $document
            )

                <tr>

                    <td>
                        {{ $key + 1 }}
                    </td>

                    <td>
                        {{ $document->document_name }}
                    </td>

                    <td>

                        <a
                            href="{{ asset(
                                'storage/' .
                                $document->file_path
                            ) }}"
                            target="_blank"
                        >
                            View Document
                        </a>

                    </td>

                </tr>

            @empty

                <tr>

                    <td
                        colspan="3"
                        style="text-align:center;"
                    >
                        NO RECORD FOUND
                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>


        <!-- =================================================
             DECLARATION
        ================================================== -->

        <div class="declaration">

            <form
                method="POST"
                action="{{ route(
                    'student.registration.form.submit'
                ) }}"
            >

                @csrf


                <label>

                    <input
                        type="checkbox"
                        name="declaration"
                        value="1"
                        required
                    >

                    <span>

                        I hereby declare that the entries made by
                        me in the Application Form are complete and
                        true to the best of my knowledge, belief and
                        information. I take full responsibility for
                        every entry, record, data and document
                        submitted by me in this form.

                    </span>

                </label>


                <div
                    style="
                        text-align:center;
                        margin-top:20px;
                    "
                >

                    <button
                        type="submit"
                        class="btn btn-submit"
                    >
                        SUBMIT APPLICATION
                    </button>

                </div>

            </form>

        </div>


    </div>


    <!-- =====================================================
         PAGE ACTIONS
    ====================================================== -->

    <div class="actions">


        <a
            href="{{ route('student.documents') }}"
            class="btn btn-back"
        >
            ← BACK
        </a>


        <button
            type="button"
            onclick="window.print()"
            class="btn btn-print"
        >
            🖨 PRINT
        </button>


    </div>


</main>


</body>

</html>