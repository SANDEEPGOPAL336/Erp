<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\StudentProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PersonalInformationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | STEP 2 - SHOW PERSONAL INFORMATION
    |--------------------------------------------------------------------------
    */

    public function edit(Request $request)
    {
        $user = $request->user();

        $profile = StudentProfile::firstOrCreate(
            [
                'user_id' => $user->id,
            ],
            [
                'registration_no' =>
                    'REG-' .
                    now()->format('Y') .
                    '-' .
                    str_pad(
                        (string) $user->id,
                        6,
                        '0',
                        STR_PAD_LEFT
                    ),

                'nationality' => 'Indian',
                'permanent_country' => 'India',
                'correspondence_country' => 'India',
            ]
        );

        return view(
            'student.personal',
            compact('profile')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | STEP 2 - SAVE PERSONAL INFORMATION
    |--------------------------------------------------------------------------
    */

    public function update(Request $request)
    {
        $validated = $request->validate([

            /*
            |--------------------------------------------------------------------------
            | Parents / Contact
            |--------------------------------------------------------------------------
            */

            'father_name' => [
                'required',
                'string',
                'max:150',
            ],

            'father_mobile' => [
                'nullable',
                'digits:10',
            ],

            'mother_name' => [
                'required',
                'string',
                'max:150',
            ],

            'mother_mobile' => [
                'nullable',
                'digits:10',
            ],

            'alternate_mobile' => [
                'nullable',
                'digits:10',
            ],


            /*
            |--------------------------------------------------------------------------
            | Personal Details
            |--------------------------------------------------------------------------
            */

            'date_of_birth' => [
                'required',
                'date',
                'before:today',
            ],

            'gender' => [
                'required',
                'in:Male,Female,Other',
            ],

            'blood_group' => [
                'nullable',
                'string',
                'max:10',
            ],

            'marital_status' => [
                'nullable',
                'string',
                'max:30',
            ],

            'category' => [
                'required',
                'string',
                'max:100',
            ],

            'sub_category' => [
                'nullable',
                'string',
                'max:100',
            ],

            'religion' => [
                'nullable',
                'string',
                'max:50',
            ],

            'nationality' => [
                'required',
                'string',
                'max:50',
            ],


            /*
            |--------------------------------------------------------------------------
            | Permanent Address
            |--------------------------------------------------------------------------
            */

            'permanent_address' => [
                'required',
                'string',
                'max:2000',
            ],

            'permanent_post_office' => [
                'required',
                'string',
                'max:150',
            ],

            'permanent_tehsil' => [
                'required',
                'string',
                'max:100',
            ],

            'permanent_district' => [
                'required',
                'string',
                'max:100',
            ],

            'permanent_state' => [
                'required',
                'string',
                'max:100',
            ],

            'permanent_country' => [
                'required',
                'string',
                'max:100',
            ],

            'permanent_pin_code' => [
                'required',
                'string',
                'max:10',
            ],


            /*
            |--------------------------------------------------------------------------
            | Correspondence Address
            |--------------------------------------------------------------------------
            */

            'same_correspondence_address' => [
                'nullable',
                'boolean',
            ],

            'correspondence_address' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'correspondence_post_office' => [
                'nullable',
                'string',
                'max:150',
            ],

            'correspondence_tehsil' => [
                'nullable',
                'string',
                'max:100',
            ],

            'correspondence_district' => [
                'nullable',
                'string',
                'max:100',
            ],

            'correspondence_state' => [
                'nullable',
                'string',
                'max:100',
            ],

            'correspondence_country' => [
                'nullable',
                'string',
                'max:100',
            ],

            'correspondence_pin_code' => [
                'nullable',
                'string',
                'max:10',
            ],


            /*
            |--------------------------------------------------------------------------
            | Other Information
            |--------------------------------------------------------------------------
            */

            'irdp_bpl' => ['nullable', 'boolean'],
            'sports_quota' => ['nullable', 'boolean'],
            'himachali_bonafide' => ['nullable', 'boolean'],
            'cultural_quota' => ['nullable', 'boolean'],
            'minority_region' => ['nullable', 'boolean'],
            'physically_challenged' => ['nullable', 'boolean'],
            'gap_after_12th' => ['nullable', 'boolean'],
            'single_girl_child' => ['nullable', 'boolean'],
            'ncc' => ['nullable', 'boolean'],
            'nss' => ['nullable', 'boolean'],
            'punished' => ['nullable', 'boolean'],
            'related_student' => ['nullable', 'boolean'],
            'serious_illness' => ['nullable', 'boolean'],
            'sports_cultural_distinction' => [
                'nullable',
                'boolean'
            ],

            // Student photograph and signature (maximum 2 MB each)
            'student_photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
            ],

            'signature' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Checkbox Values
        |--------------------------------------------------------------------------
        */

        $booleanFields = [

            'same_correspondence_address',

            'irdp_bpl',
            'sports_quota',
            'himachali_bonafide',
            'cultural_quota',
            'minority_region',
            'physically_challenged',
            'gap_after_12th',
            'single_girl_child',
            'ncc',
            'nss',
            'punished',
            'related_student',
            'serious_illness',
            'sports_cultural_distinction',

        ];


        foreach (
            $booleanFields
            as $field
        ) {

            $validated[$field] =
                $request->boolean($field);

        }


        /*
        |--------------------------------------------------------------------------
        | Same Address
        |--------------------------------------------------------------------------
        */

        if (
            $validated[
                'same_correspondence_address'
            ]
        ) {

            $validated[
                'correspondence_address'
            ] =
                $validated[
                    'permanent_address'
                ];

            $validated[
                'correspondence_post_office'
            ] =
                $validated[
                    'permanent_post_office'
                ];

            $validated[
                'correspondence_tehsil'
            ] =
                $validated[
                    'permanent_tehsil'
                ];

            $validated[
                'correspondence_district'
            ] =
                $validated[
                    'permanent_district'
                ];

            $validated[
                'correspondence_state'
            ] =
                $validated[
                    'permanent_state'
                ];

            $validated[
                'correspondence_country'
            ] =
                $validated[
                    'permanent_country'
                ];

            $validated[
                'correspondence_pin_code'
            ] =
                $validated[
                    'permanent_pin_code'
                ];
        }


        /*
        |--------------------------------------------------------------------------
        | Get/Create Student Profile
        |--------------------------------------------------------------------------
        */

        $profile = StudentProfile::firstOrCreate(
            [
                'user_id' =>
                    $request->user()->id,
            ],
            [
                'registration_no' =>
                    'REG-' .
                    now()->format('Y') .
                    '-' .
                    str_pad(
                        (string) $request->user()->id,
                        6,
                        '0',
                        STR_PAD_LEFT
                    ),

                'nationality' => 'Indian',

                'permanent_country' =>
                    'India',

                'correspondence_country' =>
                    'India',
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | Store photograph and signature, if newly uploaded
        |--------------------------------------------------------------------------
        */

        $studentPhoto = $request->file('student_photo');
        $signature = $request->file('signature');

        // Remove UploadedFile objects from the array sent to the model.
        unset($validated['student_photo'], $validated['signature']);

        if ($studentPhoto) {
            $newPhotoPath = $studentPhoto->store('student-photos', 'public');

            if ($newPhotoPath) {
                if ($profile->student_photo_path) {
                    Storage::disk('public')->delete($profile->student_photo_path);
                }

                $validated['student_photo_path'] = $newPhotoPath;
            }
        }

        if ($signature) {
            $newSignaturePath = $signature->store('student-signatures', 'public');

            if ($newSignaturePath) {
                if ($profile->signature_path) {
                    Storage::disk('public')->delete($profile->signature_path);
                }

                $validated['signature_path'] = $newSignaturePath;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Save profile information
        |--------------------------------------------------------------------------
        */

        $profile->update($validated);


        /*
        |--------------------------------------------------------------------------
        | Go Back To Dashboard
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('student.dashboard')
            ->with(
                'success',
                'Personal information saved successfully.'
            );
    }
}