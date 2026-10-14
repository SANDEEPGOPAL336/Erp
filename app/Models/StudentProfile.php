<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class StudentProfile extends Model
{
    protected $fillable = [
        'user_id',
        'registration_no',
        'course_id',
        'aadhaar_no',

        'father_name',
        'father_mobile',
        'mother_name',
        'mother_mobile',
        'alternate_mobile',

        'date_of_birth',
        'gender',
        'blood_group',
        'marital_status',

        'category',
        'sub_category',
        'religion',
        'nationality',

        'permanent_address',
        'permanent_post_office',
        'permanent_tehsil',
        'permanent_district',
        'permanent_state',
        'permanent_country',
        'permanent_pin_code',

        'same_correspondence_address',
        'correspondence_address',
        'correspondence_post_office',
        'correspondence_tehsil',
        'correspondence_district',
        'correspondence_state',
        'correspondence_country',
        'correspondence_pin_code',

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

        'profile_image',
        'signature_image',
        'student_photo_path',
        'signature_path',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',

            'same_correspondence_address' => 'boolean',

            'irdp_bpl' => 'boolean',
            'sports_quota' => 'boolean',
            'himachali_bonafide' => 'boolean',
            'cultural_quota' => 'boolean',
            'minority_region' => 'boolean',
            'physically_challenged' => 'boolean',
            'gap_after_12th' => 'boolean',
            'single_girl_child' => 'boolean',
            'ncc' => 'boolean',
            'nss' => 'boolean',
            'punished' => 'boolean',
            'related_student' => 'boolean',
            'serious_illness' => 'boolean',
            'sports_cultural_distinction' => 'boolean',
        ];
    }
public function qualifications(): HasMany
{
    return $this->hasMany(
        StudentQualification::class,
        'student_profile_id'
    );
}

public function documents(): HasMany
{
    return $this->hasMany(
        StudentDocument::class,
        'student_profile_id'
    );
}

}