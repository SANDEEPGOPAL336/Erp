<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>College ERP Login</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f3f1f8;
            font-family: Arial, sans-serif;
        }

        .login-box {
            width: 420px;
        }

        .login-header {
            background: #40358f;
            color: white;
            text-align: center;
            padding: 25px;
            border-radius: 10px 10px 0 0;
        }

        .login-body {
            background: white;
            padding: 30px;
            border-radius: 0 0 10px 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }

        .login-btn {
            background: #40358f;
            color: white;
            width: 100%;
        }

        .login-btn:hover {
            background: #30266f;
            color: white;
        }

    </style>

</head>

<body>

<div class="login-box">

    <div class="login-header">

        <h3 class="mb-1">
            College ERP
        </h3>

        <small>
            Academic Session 2026-27
        </small>

    </div>

    <div class="login-body">

        @if($errors->any())

            <div class="alert alert-danger">

                {{ $errors->first() }}

            </div>

        @endif

        @if(session('success'))

            <div class="alert alert-success">

                {{ session('success') }}

            </div>

        @endif

        <h5 class="mb-4">
            Login
        </h5>

        <form
            method="POST"
            action="{{ route('login') }}"
        >

            @csrf

            <div class="mb-3">

                <label class="form-label">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    class="form-control"
                    value="{{ old('email') }}"
                    required
                >

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Password
                </label>

                <input
                    type="password"
                    name="password"
                    class="form-control"
                    required
                >

            </div>

            <button
                type="submit"
                class="btn login-btn"
            >
                LOGIN
            </button>

        </form>

        <div class="text-center mt-4">

            <span>
                New Student?
            </span>

            <a href="{{ route('register') }}">
                Register Here
            </a>

        </div>

    </div>

</div>

</body>

</html>