<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>
        Registration Form
    </title>

    <style>

        body {
            margin: 0;

            font-family: Arial, sans-serif;

            background: #f4f5f9;

            color: #111;
        }

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

        .sidebar {
            position: fixed;

            top: 62px;
            bottom: 0;
            left: 0;

            width: 230px;

            background: #cecece;

            overflow-y: auto;
        }

        .logo-area {
            text-align: center;

            padding: 20px;

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

            margin: auto auto 10px;

            color: #40358f;

            font-weight: bold;
        }

        .menu-link {
            display: block;

            padding: 12px 14px;

            text-decoration: none;

            color: #222;

            font-size: 13px;
        }

        .menu-link:hover,
        .active {
            background: white;
        }

        .content {
            margin-left: 230px;

            padding: 90px 30px 50px;
        }

        .form-wrapper {
            max-width: 1000px;

            margin: auto;

            background: white;

            border: 1px solid #d4d4d4;
        }

        .college-header {
            text-align: center;

            padding: 20px;

            border-bottom: 1px solid #ccc;
        }

        .college-header h2 {
            color: #d71920;

            margin: 5px 0;
        }

        .college-header p {
            margin: 3px;
        }

        .bar {
            background: #40358f;

            color: white;

            padding: 8px 10px;

            font-weight: bold;
        }

        table {
            width: 100%;

            border-collapse: collapse;
        }

        td,
        th {
            border: 1px solid #ddd;

            padding: 8px;

            font-size: 12px;

            text-align: left;
        }

        .label {
            font-weight: bold;

            width: 20%;
        }

        .subsection {
            margin-top: 20px;
        }

        .document-link {
            color: #40358f;

            text-decoration: none;
        }

        .success {
            max-width: 1000px;

            margin: 0 auto 20px;

            background: #d1e7dd;

            color: #0f5132;

            padding: 12px;

            border-radius: 5px;
        }

        .error {
            max-width: 1000px;

            margin: 0 auto 20px;

            background: #f8d7da;

            color: #842029;

            padding: 12px;

            border-radius: 5px;
        }

        .actions {
            max-width: 1000px;

            margin: 20px auto;

            display: flex;

            justify-content: space-between;
        }

        .btn {
            padding: 10px 20px;

            border: 0;

            border-radius: 5px;

            text-decoration: none;

            cursor: pointer;

            display: inline-block;
        }

        .print {
            background: #6c757d;

            color: white;
        }

        .submit {
            background: #198754;

            color: white;
        }

        .back {
            background: #ffc107;

            color: #222;
        }

        .declaration {
            padding: 15px;

            font-size: 13px;

            line-height: 1.6;
        }

    </style>

</head>

<body>


<header class="topbar">

    <strong>
        Student Panel
    </strong>

    <span>
        {{ auth()->user()->name }}
    </span>

</header>


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
    >

        @csrf

        <button
            class="menu-link"
            style="
                border:0;
                background:transparent;
                width:100%;
                text-align:left;
                cursor:pointer;
            "
        >
            🔒 Sign Out
        </button>

    </form>

</aside>


<main class="content">


@if(session('success'))

    <div class="success">

        {{ session('success') }}

    </div>

@endif


@if($errors->any())

    <div class="error">

        @foreach($errors->all() as $error)

            <div>
                {{ $error }}
            </div>

        @endforeach

    </div>

@endif


<div class="form-wrapper">


    <!-- COLLEGE HEADER -->

    <div class="college-header">

        <div>
            COLLEGE LOGO
        </div>

        <h2>
            YOUR COLLEGE NAME
        </h2>

        <p>
            Academic Session:
            {{ $application->session?->name ?? '2026-27' }}
        </p>

    </div>


    <!-- COURSE -->

    <div class="bar">

        ADMISSION IN :
        {{ $application->course?->name }}

        @if($application->semester)
            |
            Semester:
            {{ $application->semester->name }}
        @endif

    </div>


    <table>

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
                {{ $profile->registration_no }}
            </td>

        </tr>


        <tr>

            <td class="label">
                Date of Birth
            </td>

            <td>
                {{ optional(
                    $profile->date_of_birth
                )->format('d-m-Y') }}
            </td>

            <td class="label">
                Gender
            </td>

            <td>
                {{ $profile->gender }}
            </td>

        </tr>


        <tr>

            <td class="label">
                Aadhaar No
            </td>

            <td>
                {{ $profile->aadhaar_no }}
            </td>

            <td class="label">
                Contact No
            </td>

            <td>
                {{ auth()->user()->phone }}
            </td>

        </tr>


        <tr>

            <td class="label">
                Father's Name
            </td>

            <td>
                {{ $profile->father_name }}
            </td>

            <td class="label">
                Father's Contact
            </td>

            <td>
                {{ $profile->father_mobile }}
            </td>

        </tr>


        <tr>

            <td class="label">
                Mother's Name
            </td>

            <td>
                {{ $profile->mother_name }}
            </td>

            <td class="label">
                Mother's Contact
            </td>

            <td>
                {{ $profile->mother_mobile }}
            </td>

        </tr>

    </table>


    <!-- PERMANENT ADDRESS -->

    <div class="bar">
        PERMANENT ADDRESS
    </div>

    <table>

        <tr>

            <td class="label">
                Address
            </td>

            <td colspan="3">
                {{ $profile->permanent_address }}
            </td>

        </tr>


        <tr>

            <td class="label">
                Post Office
            </td>

            <td>
                {{ $profile->permanent_post_office }}
            </td>

            <td class="label">
                Tehsil
            </td>

            <td>
                {{ $profile->permanent_tehsil }}
            </td>

        </tr>


        <tr>

            <td class="label">
                District
            </td>

            <td>
                {{ $profile->permanent_district }}
            </td>

            <td class="label">
                State
            </td>

            <td>
                {{ $profile->permanent_state }}
            </td>

        </tr>


        <tr>

            <td class="label">
                Country
            </td>

            <td>
                {{ $profile->permanent_country }}
            </td>

            <td class="label">
                PIN Code
            </td>

            <td>
                {{ $profile->permanent_pin_code }}
            </td>

        </tr>

    </table>


    <!-- CORRESPONDENCE -->

    <div class="bar">
        CORRESPONDENCE ADDRESS
    </div>

    <table>

        <tr>

            <td class="label">
                Address
            </td>

            <td colspan="3">
                {{ $profile->correspondence_address }}
            </td>

        </tr>


        <tr>

            <td class="label">
                Post Office
            </td>

            <td>
                {{ $profile->correspondence_post_office }}
            </td>

            <td class="label">
                Tehsil
            </td>

            <td>
                {{ $profile->correspondence_tehsil }}
            </td>

        </tr>


        <tr>

            <td class="label">
                District
            </td>

            <td>
                {{ $profile->correspondence_district }}
            </td>

            <td class="label">
                State
            </td>

            <td>
                {{ $profile->correspondence_state }}
            </td>

        </tr>

    </table>


    <!-- OTHER DETAILS -->

    <div class="bar">
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
                {{ $profile->marital_status }}
            </td>

            <td class="label">
                Blood Group
            </td>

            <td>
                {{ $profile->blood_group }}
            </td>

        </tr>


        <tr>

            <td class="label">
                Nationality
            </td>

            <td>
                {{ $profile->nationality }}
            </td>

            <td class="label">
                Religion
            </td>

            <td>
                {{ $profile->religion }}
            </td>

        </tr>


        <tr>

            <td class="label">
                Category
            </td>

            <td>
                {{ $profile->category }}
            </td>

            <td class="label">
                Sub-Category
            </td>

            <td>
                {{ $profile->sub_category }}
            </td>

        </tr>


        <tr>

            <td class="label">
                IRDP/BPL
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

    </table>


    <!-- QUALIFICATIONS -->

    <div class="bar">
        QUALIFICATIONS
    </div>

    <table>

        <thead>

            <tr>

                <th>S.No.</th>

                <th>Exam Passed</th>

                <th>University/Board</th>

                <th>Roll No</th>

                <th>Passing Year</th>

                <th>Marks/CGPA</th>

                <th>Percentage</th>

                <th>Subjects</th>

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
                        $qualification->percentage,
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


    <!-- DOCUMENTS -->

    <div class="bar">
        ATTACHED CERTIFICATES
    </div>

    <table>

        <thead>

            <tr>

                <th>S.No.</th>

                <th>Document Name</th>

                <th>File</th>

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
                        class="document-link"
                        target="_blank"
                        href="{{ asset(
                            'storage/' .
                            $document->file_path
                        ) }}"
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


    <!-- DECLARATION -->

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

                I hereby declare that the entries made by me
                in the Application Form are complete and true
                to the best of my knowledge, belief and
                information. I take full responsibility for
                every entry, record, data and document
                submitted by me.

            </label>


            <div style="
                text-align:center;
                margin-top:20px;
            ">

                <button
                    type="submit"
                    class="btn submit"
                >
                    SUBMIT APPLICATION
                </button>

            </div>

        </form>

    </div>


</div>


<div class="actions">

    <a
        href="{{ route('student.documents') }}"
        class="btn back"
    >
        ← BACK
    </a>


    <button
        type="button"
        onclick="window.print()"
        class="btn print"
    >
        🖨 PRINT
    </button>

</div>


</main>


</body>

</html>