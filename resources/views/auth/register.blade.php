<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>Student Registration - College ERP</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: #f4f2f9;
            font-family: Arial, sans-serif;

            display: flex;
            justify-content: center;
            align-items: center;

            padding: 30px 15px;
        }

        .register-box {
            width: 520px;
            background: white;

            border-radius: 10px;

            overflow: hidden;

            box-shadow:
                0 5px 25px
                rgba(0, 0, 0, 0.15);
        }

        .header {
            background: #40358f;
            color: white;

            text-align: center;

            padding: 25px;
        }

        .header h2 {
            margin: 0;
        }

        .header p {
            margin: 8px 0 0;
        }

        .body {
            padding: 30px;
        }

        label {
            display: block;

            margin-bottom: 6px;

            font-weight: bold;
        }

        input,
        select {
            width: 100%;

            padding: 11px;

            margin-bottom: 18px;

            border: 1px solid #ccc;

            border-radius: 5px;
        }

        button {
            width: 100%;

            padding: 12px;

            border: none;

            border-radius: 5px;

            background: #40358f;

            color: white;

            font-size: 16px;

            cursor: pointer;
        }

        button:hover {
            background: #30266f;
        }

        .error {
            background: #f8d7da;

            color: #842029;

            padding: 12px;

            margin-bottom: 20px;

            border-radius: 5px;
        }

        .login-link {
            text-align: center;

            margin-top: 20px;
        }

        .login-link a {
            color: #40358f;

            font-weight: bold;

            text-decoration: none;
        }

    </style>

</head>

<body>

<div class="register-box">


    <!-- HEADER -->

    <div class="header">

        <h2>
            College ERP
        </h2>

        <p>
            Student Registration
        </p>

        <small>
            Academic Session 2026-27
        </small>

    </div>


    <!-- BODY -->

    <div class="body">


        @if($errors->any())

            <div class="error">

                @foreach($errors->all() as $error)

                    <div>
                        {{ $error }}
                    </div>

                @endforeach

            </div>

        @endif


        <form
            method="POST"
            action="{{ route('register.submit') }}"
        >

            @csrf


            <!-- NAME -->

            <label>
                Student Name *
            </label>

            <input
                type="text"
                name="name"
                value="{{ old('name') }}"
                placeholder="Enter student name"
                required
            >


            <!-- AADHAAR -->

            <label>
                Aadhaar Number *
            </label>

            <input
                type="text"
                name="aadhaar_no"
                value="{{ old('aadhaar_no') }}"
                maxlength="12"
                placeholder="Enter 12 digit Aadhaar"
                required
            >


            <!-- EMAIL -->

            <label>
                Email *
            </label>

            <input
                type="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="Enter email"
                required
            >


            <!-- MOBILE -->

            <label>
                Mobile Number *
            </label>

            <input
                type="text"
                name="phone"
                value="{{ old('phone') }}"
                maxlength="10"
                placeholder="Enter mobile number"
                required
            >


            <!-- PASSWORD -->

            <label>
                Password *
            </label>

            <input
                type="password"
                name="password"
                placeholder="Minimum 8 characters"
                required
            >


            <!-- CONFIRM PASSWORD -->

            <label>
                Confirm Password *
            </label>

            <input
                type="password"
                name="password_confirmation"
                placeholder="Confirm password"
                required
            >


            <!-- COURSE -->

            <label>
                Select Course *
            </label>

            <select
                name="course_id"
                required
            >

                <option value="">
                    Select Course
                </option>

                @foreach($courses as $course)

                    <option
                        value="{{ $course->id }}"
                        @selected(
                            old('course_id')
                            == $course->id
                        )
                    >

                        {{ $course->name }}

                    </option>

                @endforeach

            </select>


            <!-- BUTTON -->

            <button
                type="submit"
            >
                SIGN UP
            </button>


        </form>


        <div class="login-link">

            Already have an account?

            <a
                href="{{ route('login') }}"
            >
                Login
            </a>

        </div>


    </div>

</div>

</body>
</html>