<!DOCTYPE html>
<html>
<head>
    <title>New Applicants</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f5fb;
        }

        .header {
            background: #6f42c1;
            color: white;
            padding: 18px 30px;
            font-size: 22px;
            font-weight: bold;
        }

        .container {
            padding: 30px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,.08);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #f0ecf8;
        }

        .btn {
            display: inline-block;
            padding: 7px 12px;
            background: #6f42c1;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .success {
            padding: 12px;
            background: #d1e7dd;
            color: #0f5132;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .empty {
            text-align: center;
            padding: 30px;
            color: #777;
        }
    </style>
</head>

<body>

<div class="header">
    Unit Teacher Panel — New Applicants
</div>

<div class="container">

    @if(session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">

        <h2>New Applicants</h2>

        <p>
            Showing applications submitted for your assigned
            courses and semesters.
        </p>

        @if($applications->count())

            <table>

                <thead>
                    <tr>
                        <th>Application No.</th>
                        <th>Registration No.</th>
                        <th>Student</th>
                        <th>Father's Name</th>
                        <th>Course</th>
                        <th>Semester</th>
                        <th>Submitted</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                @foreach($applications as $application)

                    <tr>

                        <td>
                            {{ $application->application_no }}
                        </td>

                        <td>
                            {{ $application->student->studentProfile->registration_no ?? '-' }}
                        </td>

                        <td>
                            {{ $application->student->name }}
                        </td>

                        <td>
                            {{ $application->student->studentProfile->father_name ?? '-' }}
                        </td>

                        <td>
                            {{ $application->course->name ?? '-' }}
                        </td>

                        <td>
                            {{ $application->semester->name ?? '-' }}
                        </td>

                        <td>
                            {{ $application->submitted_at
                                ? $application->submitted_at->format('d-m-Y h:i A')
                                : '-' }}
                        </td>

                        <td>
                            <a
                                href="{{ route('staff.applications.show', $application->id) }}"
                                class="btn"
                            >
                                VIEW
                            </a>
                        </td>

                    </tr>

                @endforeach

                </tbody>

            </table>

            <div style="margin-top:20px;">
                {{ $applications->links() }}
            </div>

        @else

            <div class="empty">
                No new applications are available for verification.
            </div>

        @endif

    </div>

</div>

</body>
</html>