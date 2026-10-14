<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>
        Personal Information - College ERP
    </title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f4f7;
            color: #222;
        }

        .topbar {
            height: 60px;
            background: #40358f;
            color: white;

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 0 20px;

            position: fixed;
            top: 0;
            left: 0;
            right: 0;

            z-index: 1000;
        }

        .sidebar {
            position: fixed;

            top: 60px;
            left: 0;
            bottom: 0;

            width: 220px;

            background: #d0d0d0;

            overflow-y: auto;
        }

        .logo-area {
            text-align: center;

            padding: 20px 10px;

            border-bottom: 1px solid #aaa;
        }

        .logo {
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

            padding: 11px 12px;

            text-decoration: none;

            color: #222;

            font-size: 13px;
        }

        .menu-link:hover {
            background: white;
        }

        .active {
            background: white;

            border-left: 4px solid #40358f;

            font-weight: bold;
        }

        .content {
            margin-left: 220px;

            padding: 85px 25px 40px;
        }

        .page-title {
            font-size: 22px;

            margin-bottom: 20px;
        }

        .form-box {
            background: white;

            padding: 25px;

            border-radius: 8px;

            margin-bottom: 20px;

            box-shadow:
                0 2px 8px rgba(0,0,0,.08);
        }

        .section-title {
            background: #40358f;

            color: white;

            padding: 10px 14px;

            margin: -25px -25px 20px;

            border-radius: 8px 8px 0 0;

            font-size: 16px;

            font-weight: bold;
        }

        .row {
            display: grid;

            grid-template-columns:
                repeat(2, 1fr);

            gap: 18px;
        }

        .row-3 {
            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 18px;
        }

        .field {
            margin-bottom: 5px;
        }

        label {
            display: block;

            margin-bottom: 6px;

            font-size: 13px;

            font-weight: bold;
        }

        input,
        select,
        textarea {
            width: 100%;

            padding: 10px;

            border: 1px solid #ccc;

            border-radius: 5px;

            font-size: 14px;
        }

        textarea {
            min-height: 80px;

            resize: vertical;
        }

        .full {
            grid-column: 1 / -1;
        }

        .yesno-grid {
            display: grid;

            grid-template-columns:
                repeat(2, 1fr);

            gap: 12px;
        }

        .yesno-item {
            border: 1px solid #ddd;

            border-radius: 6px;

            padding: 12px;

            background: #fafafa;

            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 15px;
        }

        .yesno-item span {
            font-size: 13px;
            font-weight: bold;
        }

        .radio-group {
            display: flex;

            gap: 15px;
        }

        .radio-group label {
            display: inline-flex;

            align-items: center;

            gap: 5px;

            margin: 0;

            font-weight: normal;
        }

        .radio-group input {
            width: auto;
        }

        .buttons {
            display: flex;

            justify-content: space-between;

            margin-top: 20px;
        }

        .btn {
            padding: 11px 22px;

            border: 0;

            border-radius: 5px;

            cursor: pointer;

            font-size: 14px;

            text-decoration: none;

            display: inline-block;
        }

        .btn-back {
            background: #6c757d;

            color: white;
        }

        .btn-next {
            background: #198754;

            color: white;
        }

        .alert-success {
            background: #d1e7dd;

            color: #0f5132;

            padding: 12px;

            border-radius: 5px;

            margin-bottom: 20px;
        }

        .alert-error {
            background: #f8d7da;

            color: #842029;

            padding: 12px;

            border-radius: 5px;

            margin-bottom: 20px;
        }

        @media(max-width:900px) {

            .row,
            .row-3,
            .yesno-grid {
                grid-template-columns: 1fr;
            }

        }

        @media(max-width:700px) {

            .sidebar {
                width: 180px;
            }

            .content {
                margin-left: 180px;
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

        <div class="logo">
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
        class="menu-link active"
    >
        👤 Personal Information
    </a>


    <a
        href="#"
        class="menu-link"
    >
        🎓 Education Qualification
    </a>


    <a
        href="#"
        class="menu-link"
    >
        📄 Document Upload
    </a>


    <a
        href="#"
        class="menu-link"
    >
        📝 Registration Form
    </a>


    <form
        method="POST"
        action="{{ route('logout') }}"
    >

        <?php echo csrf_field(); ?>

        <button
            type="submit"
            class="menu-link"
            style="
                width:100%;
                border:0;
                background:transparent;
                text-align:left;
                cursor:pointer;
            "
        >
            🔒 Sign Out
        </button>

    </form>

</aside>


<main class="content">


<div class="page-title">
    STEP 2: PERSONAL INFORMATION
</div>


<?php if (session('success')): ?>

    <div class="alert-success">
        {{ session('success') }}
    </div>

<?php endif; ?>


<?php if ($errors->any()): ?>

    <div class="alert-error">

        <strong>
            Please correct the following:
        </strong>

        <ul>

            <?php foreach ($errors->all() as $error): ?>

                <li>{{ $error }}</li>

            <?php endforeach; ?>

        </ul>

    </div>

<?php endif; ?>


<form
    method="POST"
    action="{{ route('student.personal.update') }}"
    enctype="multipart/form-data"
>

<?php echo csrf_field(); ?>



<!-- STUDENT PHOTOGRAPH AND SIGNATURE -->

<div class="form-box">

    <div class="section-title">
        Student Photograph &amp; Signature
    </div>

    <div class="row">

        <div class="field">
            <label for="student_photo">Student Photograph</label>

            <?php if ($profile?->student_photo_path): ?>
                <img
                    src="{{ asset('storage/'.$profile->student_photo_path) }}"
                    alt="Student Photograph"
                    style="width:130px;height:150px;object-fit:cover;border:1px solid #ccc;border-radius:6px;display:block;margin:12px 0;"
                >
            <?php else: ?>
                <div style="width:130px;height:150px;border:1px dashed #aaa;display:flex;align-items:center;justify-content:center;text-align:center;color:#777;margin:12px 0;padding:5px;">
                    No photograph uploaded
                </div>
            <?php endif; ?>

            <input
                type="file"
                name="student_photo"
                id="student_photo"
                accept=".jpg,.jpeg,.png"
            >

            <small style="display:block;margin-top:7px;color:#666;">
                JPG, JPEG or PNG. Maximum size: 2 MB.
            </small>

            <?php if ($errors->has('student_photo')): ?>
                <div style="color:red;margin-top:5px;">{{ $message }}</div>
            <?php endif; ?>
        </div>

        <div class="field">
            <label for="signature">Student Signature</label>

            <?php if ($profile?->signature_path): ?>
                <img
                    src="{{ asset('storage/'.$profile->signature_path) }}"
                    alt="Student Signature"
                    style="width:220px;height:90px;object-fit:contain;border:1px solid #ccc;border-radius:6px;display:block;margin:12px 0;background:white;"
                >
            <?php else: ?>
                <div style="width:220px;height:90px;border:1px dashed #aaa;display:flex;align-items:center;justify-content:center;text-align:center;color:#777;margin:12px 0;padding:5px;">
                    No signature uploaded
                </div>
            <?php endif; ?>

            <input
                type="file"
                name="signature"
                id="signature"
                accept=".jpg,.jpeg,.png"
            >

            <small style="display:block;margin-top:7px;color:#666;">
                JPG, JPEG or PNG. Maximum size: 2 MB.
            </small>

            <?php if ($errors->has('signature')): ?>
                <div style="color:red;margin-top:5px;">{{ $message }}</div>
            <?php endif; ?>
        </div>

    </div>

</div>


<!-- PERSONAL INFORMATION -->

<div class="form-box">

    <div class="section-title">
        Personal Details
    </div>


    <div class="row-3">


        <div class="field">

            <label>
                Date of Birth *
            </label>

            <input
                type="date"
                name="date_of_birth"
                value="{{ old(
                    'date_of_birth',
                    optional($profile->date_of_birth)
                        ->format('Y-m-d')
                ) }}"
                required
            >

        </div>


        <div class="field">

            <label>
                Gender *
            </label>

            <select
                name="gender"
                required
            >

                <option value="">
                    Select Gender
                </option>

                <option
                    value="Male"
                    {{ old('gender', $profile->gender) === 'Male' ? 'selected' : '' }}
                >
                    Male
                </option>

                <option
                    value="Female"
                    {{ old('gender', $profile->gender) === 'Female' ? 'selected' : '' }}
                >
                    Female
                </option>

                <option
                    value="Other"
                    {{ old('gender', $profile->gender) === 'Other' ? 'selected' : '' }}
                >
                    Other
                </option>

            </select>

        </div>


        <div class="field">

            <label>
                Blood Group
            </label>

            <select name="blood_group">

                <option value="">
                    Select
                </option>

                <?php foreach (['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $group): ?>

                    <option
                        value="{{ $group }}"
                        {{ old('blood_group', $profile->blood_group) == $group ? 'selected' : '' }}
                    >
                        {{ $group }}
                    </option>

                <?php endforeach; ?>

            </select>

        </div>


        <div class="field">

            <label>
                Marital Status
            </label>

            <select name="marital_status">

                <option value="">
                    Select
                </option>

                <option
                    value="Single"
                    {{ old('marital_status', $profile->marital_status) == 'Single' ? 'selected' : '' }}
                >
                    Single
                </option>

                <option
                    value="Married"
                    {{ old('marital_status', $profile->marital_status) == 'Married' ? 'selected' : '' }}
                >
                    Married
                </option>

            </select>

        </div>


        <div class="field">

            <label>
                Category *
            </label>

            <select
                name="category"
                required
            >

                <option value="">
                    Select Category
                </option>

                <?php foreach (['General', 'SC', 'ST', 'OBC', 'EWS', 'Other'] as $category): ?>

                    <option
                        value="{{ $category }}"
                        {{ old('category', $profile->category) == $category ? 'selected' : '' }}
                    >
                        {{ $category }}
                    </option>

                <?php endforeach; ?>

            </select>

        </div>


        <div class="field">

            <label>
                Sub Category
            </label>

            <input
                type="text"
                name="sub_category"
                value="{{ old(
                    'sub_category',
                    $profile->sub_category
                ) }}"
            >

        </div>


        <div class="field">

            <label>
                Religion
            </label>

            <input
                type="text"
                name="religion"
                value="{{ old(
                    'religion',
                    $profile->religion
                ) }}"
            >

        </div>


        <div class="field">

            <label>
                Nationality *
            </label>

            <input
                type="text"
                name="nationality"
                value="{{ old(
                    'nationality',
                    $profile->nationality ?? 'Indian'
                ) }}"
                required
            >

        </div>

    </div>

</div>


<!-- PARENTS -->

<div class="form-box">

    <div class="section-title">
        Father / Mother / Contact Details
    </div>


    <div class="row">

        <div class="field">

            <label>
                Father's Name *
            </label>

            <input
                type="text"
                name="father_name"
                value="{{ old(
                    'father_name',
                    $profile->father_name
                ) }}"
                required
            >

        </div>


        <div class="field">

            <label>
                Father's Mobile
            </label>

            <input
                type="text"
                name="father_mobile"
                maxlength="10"
                value="{{ old(
                    'father_mobile',
                    $profile->father_mobile
                ) }}"
            >

        </div>


        <div class="field">

            <label>
                Mother's Name *
            </label>

            <input
                type="text"
                name="mother_name"
                value="{{ old(
                    'mother_name',
                    $profile->mother_name
                ) }}"
                required
            >

        </div>


        <div class="field">

            <label>
                Mother's Mobile
            </label>

            <input
                type="text"
                name="mother_mobile"
                maxlength="10"
                value="{{ old(
                    'mother_mobile',
                    $profile->mother_mobile
                ) }}"
            >

        </div>


        <div class="field full">

            <label>
                Alternate Mobile
            </label>

            <input
                type="text"
                name="alternate_mobile"
                maxlength="10"
                value="{{ old(
                    'alternate_mobile',
                    $profile->alternate_mobile
                ) }}"
            >

        </div>

    </div>

</div>


<!-- PERMANENT ADDRESS -->

<div class="form-box">

    <div class="section-title">
        Permanent Address
    </div>


    <div class="row">

        <div class="field full">

            <label>
                Address *
            </label>

            <textarea
                name="permanent_address"
                required
            >{{ old(
                'permanent_address',
                $profile->permanent_address
            ) }}</textarea>

        </div>


        <div class="field">

            <label>
                Post Office *
            </label>

            <input
                name="permanent_post_office"
                value="{{ old(
                    'permanent_post_office',
                    $profile->permanent_post_office
                ) }}"
                required
            >

        </div>


        <div class="field">

            <label>
                Tehsil *
            </label>

            <input
                name="permanent_tehsil"
                value="{{ old(
                    'permanent_tehsil',
                    $profile->permanent_tehsil
                ) }}"
                required
            >

        </div>


        <div class="field">

            <label>
                District *
            </label>

            <input
                name="permanent_district"
                value="{{ old(
                    'permanent_district',
                    $profile->permanent_district
                ) }}"
                required
            >

        </div>


        <div class="field">

            <label>
                State *
            </label>

            <input
                name="permanent_state"
                value="{{ old(
                    'permanent_state',
                    $profile->permanent_state
                ) }}"
                required
            >

        </div>


        <div class="field">

            <label>
                Country *
            </label>

            <input
                name="permanent_country"
                value="{{ old(
                    'permanent_country',
                    $profile->permanent_country ?? 'India'
                ) }}"
                required
            >

        </div>


        <div class="field">

            <label>
                PIN Code *
            </label>

            <input
                name="permanent_pin_code"
                maxlength="10"
                value="{{ old(
                    'permanent_pin_code',
                    $profile->permanent_pin_code
                ) }}"
                required
            >

        </div>

    </div>

</div>


<!-- CORRESPONDENCE ADDRESS -->

<div class="form-box">

    <div class="section-title">
        Correspondence Address
    </div>


    <div style="margin-bottom:20px;">

        <label style="
            display:flex;
            align-items:center;
            gap:8px;
            font-weight:normal;
        ">

            <input
                type="checkbox"
                name="same_correspondence_address"
                value="1"
                id="sameAddress"
                style="width:auto;"
                {{ (string) old('same_correspondence_address', $profile->same_correspondence_address) === '1' ? 'checked' : '' }}
            >

            Same as Permanent Address

        </label>

    </div>


    <div class="row">

        <div class="field full">

            <label>
                Address
            </label>

            <textarea
                name="correspondence_address"
                id="correspondence_address"
            >{{ old(
                'correspondence_address',
                $profile->correspondence_address
            ) }}</textarea>

        </div>


        <div class="field">

            <label>
                Post Office
            </label>

            <input
                name="correspondence_post_office"
                id="correspondence_post_office"
                value="{{ old(
                    'correspondence_post_office',
                    $profile->correspondence_post_office
                ) }}"
            >

        </div>


        <div class="field">

            <label>
                Tehsil
            </label>

            <input
                name="correspondence_tehsil"
                id="correspondence_tehsil"
                value="{{ old(
                    'correspondence_tehsil',
                    $profile->correspondence_tehsil
                ) }}"
            >

        </div>


        <div class="field">

            <label>
                District
            </label>

            <input
                name="correspondence_district"
                id="correspondence_district"
                value="{{ old(
                    'correspondence_district',
                    $profile->correspondence_district
                ) }}"
            >

        </div>


        <div class="field">

            <label>
                State
            </label>

            <input
                name="correspondence_state"
                id="correspondence_state"
                value="{{ old(
                    'correspondence_state',
                    $profile->correspondence_state
                ) }}"
            >

        </div>


        <div class="field">

            <label>
                Country
            </label>

            <input
                name="correspondence_country"
                id="correspondence_country"
                value="{{ old(
                    'correspondence_country',
                    $profile->correspondence_country ?? 'India'
                ) }}"
            >

        </div>


        <div class="field">

            <label>
                PIN Code
            </label>

            <input
                name="correspondence_pin_code"
                id="correspondence_pin_code"
                value="{{ old(
                    'correspondence_pin_code',
                    $profile->correspondence_pin_code
                ) }}"
            >

        </div>

    </div>

</div>


<!-- OTHER INFORMATION -->

<div class="form-box">

    <div class="section-title">
        Other Information
    </div>


    <div class="yesno-grid">


        <?php
            $yesNoFields = [
                'irdp_bpl' =>
                    'IRDP / BPL',

                'sports_quota' =>
                    'Sports Quota',

                'himachali_bonafide' =>
                    'Himachali Bonafide',

                'cultural_quota' =>
                    'Cultural Quota',

                'minority_region' =>
                    'Minority',

                'physically_challenged' =>
                    'Physically Challenged',

                'gap_after_12th' =>
                    'Gap After 12th',

                'single_girl_child' =>
                    'Single Girl Child',

                'ncc' =>
                    'NCC',

                'nss' =>
                    'NSS',

                'punished' =>
                    'Ever Punished',

                'related_student' =>
                    'Related Student',

                'serious_illness' =>
                    'Serious Illness',

                'sports_cultural_distinction' =>
                    'Sports / Cultural Distinction',
            ];
        ?>


        <?php foreach ($yesNoFields as $field => $label): ?>

            <div class="yesno-item">

                <span>
                    {{ $label }}
                </span>

                <div class="radio-group">

                    <label>

                        <input
                            type="radio"
                            name="{{ $field }}"
                            value="1"
                            {{ (string) old($field, $profile->$field) === '1' ? 'checked' : '' }}
                        >

                        Yes

                    </label>

                    <label>

                        <input
                            type="radio"
                            name="{{ $field }}"
                            value="0"
                            {{ in_array((string) old($field, $profile->$field), ['0'], true) ? 'checked' : '' }}
                        >

                        No

                    </label>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

</div>


<!-- BUTTONS -->

<div class="buttons">

    <a
        href="{{ route('student.admission.course') }}"
        class="btn btn-back"
    >
        ← BACK
    </a>


    <button
        type="submit"
        class="btn btn-next"
    >
        SAVE & NEXT →
    </button>

</div>


</form>


</main>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const sameAddress = document.getElementById('sameAddress');

    if (!sameAddress) {
        return;
    }

    sameAddress.addEventListener('change', function () {

        if (!this.checked) {
            return;
        }

        const permanentAddress = document.querySelector('[name="permanent_address"]');
        const permanentPostOffice = document.querySelector('[name="permanent_post_office"]');
        const permanentTehsil = document.querySelector('[name="permanent_tehsil"]');
        const permanentDistrict = document.querySelector('[name="permanent_district"]');
        const permanentState = document.querySelector('[name="permanent_state"]');
        const permanentCountry = document.querySelector('[name="permanent_country"]');
        const permanentPinCode = document.querySelector('[name="permanent_pin_code"]');

        const correspondenceAddress = document.getElementById('correspondence_address');
        const correspondencePostOffice = document.getElementById('correspondence_post_office');
        const correspondenceTehsil = document.getElementById('correspondence_tehsil');
        const correspondenceDistrict = document.getElementById('correspondence_district');
        const correspondenceState = document.getElementById('correspondence_state');
        const correspondenceCountry = document.getElementById('correspondence_country');
        const correspondencePinCode = document.getElementById('correspondence_pin_code');

        if (permanentAddress && correspondenceAddress) {
            correspondenceAddress.value = permanentAddress.value;
        }

        if (permanentPostOffice && correspondencePostOffice) {
            correspondencePostOffice.value = permanentPostOffice.value;
        }

        if (permanentTehsil && correspondenceTehsil) {
            correspondenceTehsil.value = permanentTehsil.value;
        }

        if (permanentDistrict && correspondenceDistrict) {
            correspondenceDistrict.value = permanentDistrict.value;
        }

        if (permanentState && correspondenceState) {
            correspondenceState.value = permanentState.value;
        }

        if (permanentCountry && correspondenceCountry) {
            correspondenceCountry.value = permanentCountry.value;
        }

        if (permanentPinCode && correspondencePinCode) {
            correspondencePinCode.value = permanentPinCode.value;
        }
    });

});

</script>

</body>
</html>