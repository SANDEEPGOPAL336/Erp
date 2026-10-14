<!DOCTYPE html>
<html>
<head>

    <title>Application Verification</title>

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
            max-width: 1200px;
            margin: auto;
        }

        .card {
            background: white;
            padding: 25px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,.08);
        }

        h2 {
            margin-top: 0;
            color: #4b2e83;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            width: 30%;
            background: #f5f1fb;
        }

        .success {
            padding: 12px;
            background: #d1e7dd;
            color: #0f5132;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .error {
            padding: 12px;
            background: #f8d7da;
            color: #842029;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .btn {
            border: none;
            padding: 11px 20px;
            border-radius: 5px;
            cursor: pointer;
            color: white;
            font-weight: bold;
        }

        .approve {
            background: #198754;
        }

        .reject {
            background: #dc3545;
        }

        .back {
            background: #6c757d;
            text-decoration: none;
            display: inline-block;
        }

        textarea {
            width: 100%;
            min-height: 90px;
            padding: 10px;
            box-sizing: border-box;
        }

        .document-link {
            color: #6f42c1;
            text-decoration: none;
        }
    </style>

</head>

<body>

<div class="header">
    Unit Teacher — Application Verification
</div>

<div class="container">

    @if(session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="error">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif


    {{-- BASIC APPLICATION INFORMATION --}}
    <div class="card">

        <h2>Application Information</h2>

        <table>
            <tr>
                <th>Application No.</th>
                <td>{{ $application->application_no }}</td>
            </tr>

            <tr>
                <th>Registration No.</th>
                <td>
                    {{ $application->student->studentProfile->registration_no ?? '-' }}
                </td>
            </tr>

            <tr>
                <th>Student Name</th>
                <td>{{ $application->student->name }}</td>
            </tr>

            <tr>
                <th>Email</th>
                <td>{{ $application->student->email }}</td>
            </tr>

            <tr>
                <th>Course</th>
                <td>{{ $application->course->name ?? '-' }}</td>
            </tr>

            <tr>
                <th>Academic Session</th>
                <td>{{ $application->session->name ?? '-' }}</td>
            </tr>

            <tr>
                <th>Semester</th>
                <td>{{ $application->semester->name ?? '-' }}</td>
            </tr>

            <tr>
                <th>Status</th>
                <td>{{ strtoupper($application->status) }}</td>
            </tr>
        </table>

    </div>


    {{-- PERSONAL INFORMATION --}}
    <div class="card">

        <h2>Personal Information</h2>

        <table>

            <tr>
                <th>Aadhaar</th>
                <td>{{ $application->student->studentProfile->aadhaar ?? '-' }}</td>
            </tr>

            <tr>
                <th>Date of Birth</th>
                <td>
                    {{ optional($application->student->studentProfile->date_of_birth)->format('d-m-Y') ?? '-' }}
                </td>
            </tr>

            <tr>
                <th>Gender</th>
                <td>{{ $application->student->studentProfile->gender ?? '-' }}</td>
            </tr>

            <tr>
                <th>Category</th>
                <td>{{ $application->student->studentProfile->category ?? '-' }}</td>
            </tr>

            <tr>
                <th>Sub Category</th>
                <td>{{ $application->student->studentProfile->subcategory ?? '-' }}</td>
            </tr>

            <tr>
                <th>Father's Name</th>
                <td>{{ $application->student->studentProfile->father_name ?? '-' }}</td>
            </tr>

            <tr>
                <th>Mother's Name</th>
                <td>{{ $application->student->studentProfile->mother_name ?? '-' }}</td>
            </tr>

            <tr>
                <th>Permanent Address</th>
                <td>{{ $application->student->studentProfile->permanent_address ?? '-' }}</td>
            </tr>

            <tr>
                <th>Correspondence Address</th>
                <td>{{ $application->student->studentProfile->correspondence_address ?? '-' }}</td>
            </tr>

        </table>

    </div>


    {{-- QUALIFICATIONS --}}
    <div class="card">

        <h2>Educational Qualifications</h2>

        <table>

            <thead>
                <tr>
                    <th>Qualification</th>
                    <th>Subjects / Stream</th>
                    <th>Board / University</th>
                    <th>Passing Year</th>
                    <th>Obtained</th>
                    <th>Total</th>
                    <th>Percentage</th>
                </tr>
            </thead>

            <tbody>

            @forelse(
                $application->student->studentProfile->qualifications
                as $qualification
            )

                @if($qualification->is_active)

                    <tr>

                        <td>
                            {{ $qualification->qualification_name }}
                        </td>

                        <td>
                            {{ $qualification->subjects_stream }}
                        </td>

                        <td>
                            {{ $qualification->university_board }}
                        </td>

                        <td>
                            {{ $qualification->passing_year }}
                        </td>

                        <td>
                            {{ $qualification->obtained_marks }}
                        </td>

                        <td>
                            {{ $qualification->total_marks }}
                        </td>

                        <td>
                            {{ $qualification->percentage }}%
                        </td>

                    </tr>

                @endif

            @empty

                <tr>
                    <td colspan="7">
                        No qualifications found.
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>

    </div>


    {{-- DOCUMENTS --}}
    <div class="card">

        <h2>Uploaded Documents</h2>

        <table>

            <thead>
                <tr>
                    <th>Document</th>
                    <th>File</th>
                </tr>
            </thead>

            <tbody>

            @forelse(
                $application->student->studentProfile->documents
                as $document
            )

                @if($document->is_active)

                    <tr>

                        <td>
                            {{ $document->document_name }}
                        </td>

                        <td>
                            <a
                                href="{{ asset('storage/' . $document->file_path) }}"
                                target="_blank"
                                class="document-link"
                            >
                                VIEW DOCUMENT
                            </a>
                        </td>

                    </tr>

                @endif

            @empty

                <tr>
                    <td colspan="2">
                        No documents found.
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>

    </div>


    {{-- VERIFICATION --}}
    <div class="card">

        <h2>Teacher Verification</h2>

        <form
            method="POST"
            action="{{ route('staff.applications.approve', $application->id) }}"
        >

            @csrf

            <label>
                Remarks
            </label>

            <textarea
                name="remarks"
                placeholder="Enter approval remarks (optional)"
            ></textarea>

            <br><br>

            <button
                type="submit"
                class="btn approve"
                onclick="return confirm('Are you sure you want to APPROVE this application?');"
            >
                APPROVE APPLICATION
            </button>

        </form>


        <br>


        <form
            method="POST"
            action="{{ route('staff.applications.reject', $application->id) }}"
        >

            @csrf

            <label>
                Rejection Reason
            </label>

            <textarea
                name="remarks"
                placeholder="Enter reason for rejection"
                required
            ></textarea>

            <br><br>

            <button
                type="submit"
                class="btn reject"
                onclick="return confirm('Are you sure you want to REJECT this application?');"
            >
                REJECT APPLICATION
            </button>

        </form>

        <br>

        <a
            href="{{ route('staff.applications.index') }}"
            class="btn back"
        >
            BACK TO APPLICANTS
        </a>

    </div>

</div>

</body>
</html>