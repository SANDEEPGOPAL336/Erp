<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <title>
        Education Qualifications
    </title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f5f9;
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
            left: 0;
            bottom: 0;

            width: 230px;

            background: #cecece;

            overflow-y: auto;
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

            color: #40358f;

            display: flex;
            align-items: center;
            justify-content: center;

            margin: auto auto 10px;

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
        .menu-link.active {
            background: white;
        }

        .main-content {
            margin-left: 230px;

            padding: 88px 30px 40px;
        }

        .title {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 18px;
        }

        .card {
            background: white;

            padding: 25px;

            border-radius: 8px;

            margin-bottom: 25px;

            box-shadow:
                0 2px 8px rgba(0,0,0,.08);
        }

        .section-title {
            background: #40358f;

            color: white;

            padding: 10px 12px;

            margin: -25px -25px 25px;

            border-radius: 8px 8px 0 0;

            font-weight: bold;
        }

        .row {
            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 15px;
        }

        .field {
            margin-bottom: 8px;
        }

        .full {
            grid-column: 1 / -1;
        }

        label {
            display: block;

            font-size: 13px;

            font-weight: bold;

            margin-bottom: 6px;
        }

        input,
        select {
            width: 100%;

            padding: 10px;

            border: 1px solid #ccc;

            border-radius: 5px;
        }

        .button-area {
            text-align: center;

            margin-top: 15px;
        }

        .btn {
            border: 0;

            border-radius: 5px;

            padding: 10px 20px;

            cursor: pointer;

            text-decoration: none;

            display: inline-block;
        }

        .btn-add {
            background: #198754;
            color: white;
        }

        .btn-edit {
            background: #5cb85c;
            color: white;
        }

        .btn-disable {
            background: #dc3545;
            color: white;
        }

        .success {
            padding: 12px;

            background: #d1e7dd;

            color: #0f5132;

            margin-bottom: 20px;

            border-radius: 5px;
        }

        .error {
            padding: 12px;

            background: #f8d7da;

            color: #842029;

            margin-bottom: 20px;

            border-radius: 5px;
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;

            border-collapse: collapse;

            min-width: 1000px;
        }

        th {
            background: #e9ecef;

            padding: 9px;

            border: 1px solid #ccc;

            text-align: left;

            font-size: 12px;
        }

        td {
            padding: 9px;

            border: 1px solid #ddd;

            font-size: 12px;
        }

        @media(max-width:900px) {

            .row {
                grid-template-columns: 1fr;
            }

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
        class="menu-link active"
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
        class="menu-link"
    >
        📝 Registration Form
    </a>

    <form
        method="POST"
        action="{{ route('logout') }}"
    >

        @csrf

        <button
            type="submit"
            class="menu-link"
            style="
                width:100%;
                border:0;
                background:transparent;
                cursor:pointer;
            "
        >
            🔒 Sign Out
        </button>

    </form>

</aside>


<main class="main-content">

    <div class="title">
        STEP-3: FILL EDUCATION QUALIFICATIONS
    </div>


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


    <!-- ADD QUALIFICATION -->

    <div class="card">

        <div class="section-title">
            Qualification Details
        </div>

        <form
            method="POST"
            action="{{ route('student.qualifications.store') }}"
        >

            @csrf

            <div class="row">


                <div class="field">

                    <label>
                        Qualification Name *
                    </label>

                    <select
                        name="qualification_name"
                        required
                    >

                        <option value="">
                            Select Qualification
                        </option>

                        <option>
                            Matriculation
                        </option>

                        <option>
                            Higher Secondary Education
                        </option>

                        <option>
                            Graduation
                        </option>

                        <option>
                            Post Graduation
                        </option>

                        <option>
                            Diploma
                        </option>

                        <option>
                            Other
                        </option>

                    </select>

                </div>


                <div class="field">

                    <label>
                        Subjects / Stream *
                    </label>

                    <input
                        name="subjects_stream"
                        placeholder="Medical / Non-Medical / Arts / Commerce"
                        required
                    >

                </div>


                <div class="field">

                    <label>
                        University / Board *
                    </label>

                    <input
                        name="university_board"
                        required
                    >

                </div>


                <div class="field">

                    <label>
                        University / Board Roll No. *
                    </label>

                    <input
                        name="board_roll_no"
                        required
                    >

                </div>


                <div class="field">

                    <label>
                        School / Institute / Organization *
                    </label>

                    <input
                        name="school_institute"
                        required
                    >

                </div>


                <div class="field">

                    <label>
                        Result Type *
                    </label>

                    <select
                        name="result_type"
                        required
                    >

                        <option value="">
                            Select Result Type
                        </option>

                        <option>
                            Marks
                        </option>

                        <option>
                            Percentage
                        </option>

                        <option>
                            CGPA
                        </option>

                    </select>

                </div>


                <div class="field">

                    <label>
                        Passing Year *
                    </label>

                    <input
                        type="number"
                        name="passing_year"
                        min="1900"
                        max="{{ date('Y') }}"
                        required
                    >

                </div>


                <div class="field">

                    <label>
                        Obtained Marks / CGPA *
                    </label>

                    <input
                        type="number"
                        step="0.01"
                        name="obtained_marks"
                        id="obtainedMarks"
                        required
                    >

                </div>


                <div class="field">

                    <label>
                        Total Marks / CGPA *
                    </label>

                    <input
                        type="number"
                        step="0.01"
                        name="total_marks"
                        id="totalMarks"
                        required
                    >

                </div>

            </div>


            <div class="field">

                <label>
                    Percentage
                </label>

                <input
                    id="percentage"
                    type="text"
                    readonly
                    placeholder="Automatically calculated"
                >

            </div>


            <div class="button-area">

                <button
                    type="submit"
                    class="btn btn-add"
                >
                    ADD
                </button>

                <a
                    href="{{ route('student.documents') }}"
                    class="btn"
                    style="
                        background:#ffc107;
                        color:#222;
                    "
                >
                    NEXT
                </a>

            </div>

        </form>

    </div>


    <!-- EXISTING QUALIFICATIONS -->

    <div class="card">

        <div class="section-title">
            Qualification Records
        </div>


        <div class="table-wrap">

            <table>

                <thead>

                    <tr>

                        <th>S.No.</th>

                        <th>Qualification Name</th>

                        <th>University/Board</th>

                        <th>Passing Year</th>

                        <th>Marks/CGPA</th>

                        <th>Percentage</th>

                        <th>Subjects/Stream</th>

                        <th>Board Roll No</th>

                        <th>School/Organization</th>

                        <th>Edit</th>

                        <th>Disable</th>

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

                        <td>
                            {{ $qualification->board_roll_no }}
                        </td>

                        <td>
                            {{ $qualification->school_institute }}
                        </td>

                        <td>

                            <a
                                href="{{ route(
                                    'student.qualifications.edit',
                                    $qualification
                                ) }}"
                                class="btn btn-edit"
                            >
                                Edit
                            </a>

                        </td>

                        <td>

                            <form
                                method="POST"
                                action="{{ route(
                                    'student.qualifications.disable',
                                    $qualification
                                ) }}"
                            >

                                @csrf

                                <button
                                    class="btn btn-disable"
                                >
                                    Disable
                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="11"
                            style="text-align:center;"
                        >
                            NO RECORD FOUND
                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</main>


<script>

const obtained =
    document.getElementById('obtainedMarks');

const total =
    document.getElementById('totalMarks');

const percentage =
    document.getElementById('percentage');

function calculatePercentage()
{
    const obtainedValue =
        parseFloat(obtained.value);

    const totalValue =
        parseFloat(total.value);

    if (
        !isNaN(obtainedValue) &&
        !isNaN(totalValue) &&
        totalValue > 0
    ) {

        percentage.value =
            (
                (
                    obtainedValue /
                    totalValue
                ) * 100
            ).toFixed(2);

    } else {

        percentage.value = '';

    }
}

obtained.addEventListener(
    'input',
    calculatePercentage
);

total.addEventListener(
    'input',
    calculatePercentage
);

</script>

</body>
</html>