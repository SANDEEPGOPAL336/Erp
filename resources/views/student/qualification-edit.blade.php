<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <title>Edit Qualification</title>

    <style>

        body {
            font-family: Arial;
            background: #f4f5f9;
            margin: 0;
        }

        .box {
            max-width: 900px;
            margin: 60px auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
        }

        h2 {
            color: #40358f;
        }

        .grid {
            display: grid;
            grid-template-columns:
                repeat(2, 1fr);
            gap: 15px;
        }

        .field label {
            display: block;
            margin-bottom: 6px;
        }

        input,
        select {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
        }

        button,
        a {
            margin-top: 20px;
            padding: 10px 20px;
            border: 0;
            text-decoration: none;
            display: inline-block;
        }

        button {
            background: #198754;
            color: white;
        }

        a {
            background: #6c757d;
            color: white;
        }

    </style>

</head>

<body>

<div class="box">

    <h2>
        Edit Qualification
    </h2>

    <form
        method="POST"
        action="{{ route(
            'student.qualifications.update',
            $qualification
        ) }}"
    >

        @csrf

        @method('PUT')


        <div class="grid">


            <div class="field">

                <label>
                    Qualification Name
                </label>

                <input
                    name="qualification_name"
                    value="{{ $qualification->qualification_name }}"
                    required
                >

            </div>


            <div class="field">

                <label>
                    Subjects / Stream
                </label>

                <input
                    name="subjects_stream"
                    value="{{ $qualification->subjects_stream }}"
                    required
                >

            </div>


            <div class="field">

                <label>
                    University / Board
                </label>

                <input
                    name="university_board"
                    value="{{ $qualification->university_board }}"
                    required
                >

            </div>


            <div class="field">

                <label>
                    Board Roll No
                </label>

                <input
                    name="board_roll_no"
                    value="{{ $qualification->board_roll_no }}"
                    required
                >

            </div>


            <div class="field">

                <label>
                    School / Institute
                </label>

                <input
                    name="school_institute"
                    value="{{ $qualification->school_institute }}"
                    required
                >

            </div>


            <div class="field">

                <label>
                    Result Type
                </label>

                <select
                    name="result_type"
                    required
                >

                    <option>
                        {{ $qualification->result_type }}
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
                    Passing Year
                </label>

                <input
                    type="number"
                    name="passing_year"
                    value="{{ $qualification->passing_year }}"
                    required
                >

            </div>


            <div class="field">

                <label>
                    Obtained Marks / CGPA
                </label>

                <input
                    type="number"
                    step="0.01"
                    name="obtained_marks"
                    value="{{ $qualification->obtained_marks }}"
                    required
                >

            </div>


            <div class="field">

                <label>
                    Total Marks / CGPA
                </label>

                <input
                    type="number"
                    step="0.01"
                    name="total_marks"
                    value="{{ $qualification->total_marks }}"
                    required
                >

            </div>

        </div>


        <button>
            UPDATE
        </button>

        <a
            href="{{ route('student.qualifications') }}"
        >
            BACK
        </a>

    </form>

</div>

</body>

</html>