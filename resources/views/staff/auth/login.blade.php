<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Staff Login - College ERP
    </title>


    <style>

        * {
            box-sizing: border-box;
        }


        body {

            margin: 0;

            min-height: 100vh;

            display: flex;

            align-items: center;

            justify-content: center;

            font-family: Arial, Helvetica, sans-serif;

            background: #f2f3f7;

        }


        .login-wrapper {

            width: 100%;

            max-width: 430px;

            padding: 20px;

        }


        .login-card {

            background: white;

            border-radius: 14px;

            overflow: hidden;

            box-shadow:
                0 10px 35px rgba(0, 0, 0, .10);

        }


        .login-header {

            background: #5b3cae;

            color: white;

            text-align: center;

            padding: 25px 20px;

        }


        .logo {

            width: 58px;

            height: 58px;

            margin: 0 auto 10px;

            border-radius: 50%;

            background: rgba(255,255,255,.15);

            border: 2px solid rgba(255,255,255,.45);

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 26px;

        }


        .login-header h1 {

            margin: 0 0 5px;

            font-size: 22px;

        }


        .login-header p {

            margin: 0;

            font-size: 12px;

            opacity: .9;

        }


        .login-body {

            padding: 25px;

        }


        .alert {

            padding: 12px 14px;

            border-radius: 7px;

            margin-bottom: 18px;

            font-size: 13px;

        }


        .alert-danger {

            background: #f8d7da;

            color: #842029;

            border-left: 4px solid #dc3545;

        }


        .form-group {

            margin-bottom: 18px;

        }


        label {

            display: block;

            margin-bottom: 7px;

            font-size: 13px;

            font-weight: bold;

            color: #39354c;

        }


        input {

            width: 100%;

            padding: 12px 13px;

            border: 1px solid #d7d4df;

            border-radius: 7px;

            font-size: 14px;

            outline: none;

        }


        input:focus {

            border-color: #5b3cae;

            box-shadow:
                0 0 0 3px rgba(91,60,174,.10);

        }


        .login-btn {

            width: 100%;

            border: 0;

            background: #5b3cae;

            color: white;

            padding: 12px;

            border-radius: 7px;

            font-size: 14px;

            font-weight: bold;

            cursor: pointer;

        }


        .login-btn:hover {

            background: #4c3195;

        }


        .back-link {

            display: block;

            text-align: center;

            margin-top: 18px;

            color: #5b3cae;

            text-decoration: none;

            font-size: 12px;

        }


        .back-link:hover {

            text-decoration: underline;

        }


        .login-note {

            margin-top: 18px;

            padding: 12px;

            border-radius: 7px;

            background: #f5f3fa;

            color: #6d687b;

            font-size: 11px;

            line-height: 1.5;

            text-align: center;

        }

    </style>

</head>


<body>


<div class="login-wrapper">


    <div class="login-card">


        <div class="login-header">

            <div class="logo">
                🎓
            </div>

            <h1>
                College ERP
            </h1>

            <p>
                Staff / Unit Teacher Login
            </p>

        </div>



        <div class="login-body">


            {{-- LOGIN ERROR --}}

            @if(session('error'))

                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>

            @endif


            {{-- VALIDATION ERRORS --}}

            @if($errors->any())

                <div class="alert alert-danger">

                    @foreach($errors->all() as $error)

                        <div>
                            {{ $error }}
                        </div>

                    @endforeach

                </div>

            @endif



            {{-- STAFF LOGIN FORM --}}

            <form
                method="POST"
                action="{{ route('staff.login.submit') }}"
            >

                @csrf


                <div class="form-group">

                    <label for="email">
                        Staff Login Email
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Enter staff email"
                        autocomplete="username"
                        required
                    >

                </div>



                <div class="form-group">

                    <label for="password">
                        Password
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Enter password"
                        autocomplete="current-password"
                        required
                    >

                </div>



                <button
                    type="submit"
                    class="login-btn"
                >
                    Login
                </button>


            </form>



            <div class="login-note">

                Staff login credentials are created by
                the College Administrator.

            </div>


            <a
                href="{{ route('login') }}"
                class="back-link"
            >
                ← Back to Main Login

            </a>


        </div>

    </div>

</div>


</body>

</html>