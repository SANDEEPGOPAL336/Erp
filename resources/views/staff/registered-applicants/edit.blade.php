<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Registered Applicant — College ERP</title>
<style>
*{box-sizing:border-box}body{margin:0;background:#f4f6fb;color:#1e2740;font-family:Segoe UI,Arial,sans-serif}.topbar{background:linear-gradient(100deg,#744eea,#4f36c3);color:#fff;padding:18px 25px;font-weight:800}.wrap{max-width:1250px;margin:25px auto;padding:0 18px}.panel{background:#fff;border:1px solid #e4e8f0;border-radius:16px;box-shadow:0 14px 36px #1f293710;margin-bottom:18px;overflow:hidden}.head{padding:20px;border-bottom:1px solid #e4e8f0}.head h1{margin:0;font-size:24px}.head p{color:#68738a;margin:8px 0 0;font-size:13px}.body{padding:20px}.grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:14px}.field label{display:block;font-size:11px;font-weight:800;color:#59657a;margin-bottom:6px;text-transform:uppercase}.field input,.field select,.field textarea{width:100%;padding:11px;border:1px solid #dce1ea;border-radius:9px;font:inherit;background:#fff}.field textarea{min-height:75px;resize:vertical}.section{font-weight:900;color:#5136c9;margin:0 0 16px}.table-wrap{overflow-x:auto}table{width:100%;min-width:1000px;border-collapse:collapse}th,td{padding:10px;border-bottom:1px solid #edf0f5;text-align:left;font-size:12px}th{background:#f7f8fc;color:#68738a;text-transform:uppercase}td input{width:100%;padding:8px;border:1px solid #dce1ea;border-radius:7px}.actions{display:flex;gap:10px;flex-wrap:wrap;margin:18px 0}.btn{display:inline-block;border:0;border-radius:9px;padding:12px 17px;background:#6041d8;color:#fff;text-decoration:none;font-weight:800;cursor:pointer}.btn.secondary{background:#fff;border:1px solid #dce1ea;color:#4b5563}.notice{background:#fff5df;color:#805300;padding:12px;border-radius:9px;margin-bottom:16px}.errors{background:#ffedf1;color:#a21b37;padding:12px;border-radius:9px;margin-bottom:16px}@media(max-width:800px){.grid{grid-template-columns:1fr 1fr}}@media(max-width:520px){.grid{grid-template-columns:1fr}.wrap{padding:0 10px}.body{padding:14px}}
</style>
</head>
<body>
<header class="topbar">🎓 College ERP — Unit Teacher Panel</header>
<div class="wrap">
@if(session('success'))<div class="notice">{{ session('success') }}</div>@endif
@if($errors->any())<div class="errors">@foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach</div>@endif
<div class="panel"><div class="head"><h1>Edit Registered Applicant</h1><p>Application: <strong>{{ $application->application_no }}</strong> · {{ $application->student?->name ?? 'Student' }} · Approved — Fee Pending</p></div>
<form method="POST" action="{{ route('staff.registered-applicants.update', $application->id) }}">@csrf @method('PUT')
<div class="body"><div class="notice">Editing is available only before first-fee verification and enrollment. Changes are saved to the student's application/profile.</div><h3 class="section">Admission Details</h3><div class="grid">
<div class="field"><label>Academic Session</label><input value="{{ $application->session?->name ?? '-' }}" readonly></div>
<div class="field"><label>Course / Programme</label><select name="course_id" required>@foreach($courseOptions as $course)<option value="{{ $course->id }}" @selected((int)$application->course_id === (int)$course->id)>{{ $course->code }} — {{ $course->name }}</option>@endforeach</select></div>
<div class="field"><label>Semester</label><select name="semester_id" required>@foreach($semesterOptions as $semester)<option value="{{ $semester->id }}" @selected((int)$application->semester_id === (int)$semester->id)>{{ $semester->name }} (Semester {{ $semester->semester_number }})</option>@endforeach</select></div>
</div></div>
<div class="body"><h3 class="section">Personal Information</h3><div class="grid">
@php $p = $application->student?->studentProfile; @endphp
@foreach([
'aadhaar_no'=>'Aadhaar No.','father_name'=>'Father Name','father_mobile'=>'Father Mobile','mother_name'=>'Mother Name','mother_mobile'=>'Mother Mobile','alternate_mobile'=>'Alternate Mobile','date_of_birth'=>'Date of Birth','gender'=>'Gender','blood_group'=>'Blood Group','marital_status'=>'Marital Status','category'=>'Category','sub_category'=>'Sub Category','religion'=>'Religion','nationality'=>'Nationality','permanent_post_office'=>'Permanent Post Office','permanent_tehsil'=>'Permanent Tehsil','permanent_district'=>'Permanent District','permanent_state'=>'Permanent State','permanent_country'=>'Permanent Country','permanent_pin_code'=>'Permanent PIN','correspondence_post_office'=>'Correspondence Post Office','correspondence_tehsil'=>'Correspondence Tehsil','correspondence_district'=>'Correspondence District','correspondence_state'=>'Correspondence State','correspondence_country'=>'Correspondence Country','correspondence_pin_code'=>'Correspondence PIN'] as $field=>$label)
<div class="field"><label>{{ $label }}</label><input name="profile[{{ $field }}]" value="{{ old('profile.'.$field, $p?->{$field} instanceof \Carbon\CarbonInterface ? $p->{$field}->format('Y-m-d') : ($p?->{$field} ?? '') ) }}" @if($field==='date_of_birth') type="date" @endif></div>
@endforeach
<div class="field" style="grid-column:1/-1"><label>Permanent Address</label><textarea name="profile[permanent_address]">{{ old('profile.permanent_address', $p?->permanent_address) }}</textarea></div>
<div class="field" style="grid-column:1/-1"><label>Correspondence Address</label><textarea name="profile[correspondence_address]">{{ old('profile.correspondence_address', $p?->correspondence_address) }}</textarea></div>
</div><h3 class="section" style="margin-top:24px">Additional Details / Quotas</h3><div class="grid">
@foreach(['same_correspondence_address'=>'Same Correspondence Address','irdp_bpl'=>'IRDP / BPL','sports_quota'=>'Sports Quota','himachali_bonafide'=>'Himachali Bonafide','cultural_quota'=>'Cultural Quota','minority_region'=>'Minority Region','physically_challenged'=>'Physically Challenged','gap_after_12th'=>'Gap After 12th','single_girl_child'=>'Single Girl Child','ncc'=>'NCC','nss'=>'NSS','punished'=>'Ever Punished','related_student'=>'Related Student','serious_illness'=>'Serious Illness','sports_cultural_distinction'=>'Sports / Cultural Distinction'] as $field=>$label)
<div class="field"><label><input style="width:auto" type="checkbox" name="profile[{{ $field }}]" value="1" @checked(old('profile.'.$field, $p?->{$field} ?? false))> {{ $label }}</label></div>
@endforeach
</div></div>
<div class="body"><h3 class="section">Educational Qualifications</h3><p style="color:#68738a;font-size:12px">Edit existing records or fill a blank row to add another qualification. Leave unused rows blank.</p><div class="table-wrap"><table><thead><tr><th>Qualification</th><th>Subjects / Stream</th><th>Board / University</th><th>Roll No.</th><th>School / Institute</th><th>Result Type</th><th>Passing Year</th><th>Obtained</th><th>Total</th><th>Percentage</th></tr></thead><tbody>
@php $quals = $p?->qualifications?->where('is_active', true)->values() ?? collect(); @endphp
@foreach($quals->concat(collect([null])) as $i=>$q)
<tr>@if($q)<input type="hidden" name="qualifications[{{ $i }}][id]" value="{{ $q->id }}">@endif
@foreach(['qualification_name'=>'qualification_name','subjects_stream'=>'subjects_stream','university_board'=>'university_board','board_roll_no'=>'board_roll_no','school_institute'=>'school_institute','result_type'=>'result_type','passing_year'=>'passing_year','obtained_marks'=>'obtained_marks','total_marks'=>'total_marks','percentage'=>'percentage'] as $key=>$field)
<td><input name="qualifications[{{ $i }}][{{ $field }}]" value="{{ old('qualifications.'.$i.'.'.$field, $q?->{$field} ?? '') }}" placeholder="{{ $field }}"></td>
@endforeach</tr>
@endforeach
</tbody></table></div>
<div class="actions"><button type="submit" class="btn">Save Changes</button><a class="btn secondary" href="{{ route('staff.registered-applicants.index') }}">Cancel</a></div></div>
</form></div></div>
</body></html>
