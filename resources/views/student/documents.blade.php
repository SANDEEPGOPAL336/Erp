<!DOCTYPE html>

<html lang="en">



<head>



    <meta charset="UTF-8">



    <meta name="viewport"

          content="width=device-width, initial-scale=1">



    <title>

        Document Upload

    </title>



    <style>



        body {

            margin: 0;

            background: #f4f5f9;

            font-family: Arial, sans-serif;

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



            margin: auto;



            display: flex;



            justify-content: center;



            align-items: center;



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



            padding: 90px 30px 40px;

        }



        .card {

            background: white;



            padding: 25px;



            border-radius: 8px;



            box-shadow:

                0 2px 8px rgba(0,0,0,.08);

        }



        .title {

            background: #40358f;



            color: white;



            padding: 12px;



            margin: -25px -25px 25px;



            border-radius: 8px 8px 0 0;



            font-weight: bold;

        }



        .form-row {

            display: grid;



            grid-template-columns:

                1fr 1fr;



            gap: 20px;

        }



        label {

            display: block;



            margin-bottom: 7px;



            font-weight: bold;



            font-size: 13px;

        }



        input,

        select {

            width: 100%;



            padding: 10px;



            border: 1px solid #ccc;



            border-radius: 5px;

        }



        .btn {

            border: 0;



            padding: 10px 20px;



            border-radius: 5px;



            cursor: pointer;



            text-decoration: none;



            display: inline-block;



            margin-top: 20px;

        }



        .add {

            background: #198754;



            color: white;

        }



        .next {

            background: #ffc107;



            color: #222;

        }



        table {

            width: 100%;



            border-collapse: collapse;



            margin-top: 30px;

        }



        th,

        td {

            border: 1px solid #ddd;



            padding: 10px;



            font-size: 13px;

        }



        th {

            background: #e9ecef;

        }



        .disable {

            background: #dc3545;



            color: white;



            border: 0;



            padding: 7px 12px;



            border-radius: 4px;

        }



        .success {

            background: #d1e7dd;



            color: #0f5132;



            padding: 12px;



            margin-bottom: 20px;



            border-radius: 5px;

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
        class="menu-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}"
    >
        🏠 Dashboard
    </a>


    <a
        href="{{ route('student.admission.course') }}"
        class="menu-link {{ request()->routeIs('student.admission.course') ? 'active' : '' }}"
    >
        📚 Course / Programme
    </a>


    <a
        href="{{ route('student.personal') }}"
        class="menu-link {{ request()->routeIs('student.personal') ? 'active' : '' }}"
    >
        👤 Personal Information
    </a>


    <a
        href="{{ route('student.qualifications') }}"
        class="menu-link {{ request()->routeIs('student.qualifications', 'student.qualifications.*') ? 'active' : '' }}"
    >
        🎓 Education Qualifications
    </a>


    <a
        href="{{ route('student.documents') }}"
        class="menu-link {{ request()->routeIs('student.documents', 'student.documents.*') ? 'active' : '' }}"
    >
        📄 Document Upload
    </a>


    <a
        href="{{ route('student.registration.form') }}"
        class="menu-link {{ request()->routeIs('student.registration.form', 'student.registration.form.*') ? 'active' : '' }}"
    >
        📝 Final Registration Form
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





<div class="card">



    <div class="title">



        STEP-4: UPLOAD RELEVANT DOCUMENTS



    </div>





    @if(session('success'))



        <div class="success">

            {{ session('success') }}

        </div>



    @endif





    @if($errors->any())



        <div class="success"

             style="

                background:#f8d7da;

                color:#842029;

             "

        >



            @foreach($errors->all() as $error)



                <div>

                    {{ $error }}

                </div>



            @endforeach



        </div>



    @endif





    <form

        method="POST"

        action="{{ route('student.documents.store') }}"

        enctype="multipart/form-data"

    >



        @csrf





        <div class="form-row">





            <div>



                <label>

                    Select Document \*

                </label>



                <select

                    name="document_name"

                    required

                >



                    <option value="">

                        Select Document

                    </option>



                    <option>

                        10th Certificate

                    </option>



                    <option>

                        12th Certificate

                    </option>



                    <option>

                        Graduation Certificate

                    </option>



                    <option>

                        Aadhaar Card

                    </option>



                    <option>

                        Himachali Bonafide

                    </option>



                    <option>

                        Category Certificate

                    </option>



                    <option>

                        Migration Certificate

                    </option>



                    <option>

                        Other

                    </option>



                </select>



            </div>





            <div>



                <label>

                    Upload File \*

                </label>



                <input

                    type="file"

                    name="document"

                    accept=".jpg,.jpeg,.png,.pdf"

                    required

                >



                <small>

                    JPG, JPEG, PNG or PDF.

                    Maximum 2 MB.

                </small>



            </div>



        </div>





        <button

            type="submit"

            class="btn add"

        >

            ADD

        </button>





        <a

            href="{{ route('student.registration.form') }}"

            class="btn next"

        >

            NEXT

        </a>



    </form>





    <table>



        <thead>



            <tr>



                <th>S.No.</th>



                <th>Document Name</th>



                <th>File</th>



                <th>Disable</th>



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

                        target="\_blank"

                    >

                        View File

                    </a>



                </td>



                <td>



                    <form

                        method="POST"

                        action="{{ route(

                            'student.documents.disable',

                            $document

                        ) }}"

                    >



                        @csrf



                        <button class="disable">

                            Disable

                        </button>



                    </form>



                </td>



            </tr>



        @empty



            <tr>



                <td

                    colspan="4"

                    style="

                        text-align:center;

                    "

                >

                    NO RECORD FOUND

                </td>



            </tr>



        @endforelse



        </tbody>



    </table>





</div>





</main>





</body>

</html>