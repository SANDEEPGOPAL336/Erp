<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\StudentProfile;
use App\Models\AcademicSession;
use App\Models\AdmissionApplication;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LOGIN FORM
    |--------------------------------------------------------------------------
    */

    public function loginForm()
    {
        return view('auth.login');
    }


    /*
    |--------------------------------------------------------------------------
    | LOGIN
    |--------------------------------------------------------------------------
    */

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => [
                'required',
                'email'
            ],

            'password' => [
                'required'
            ],
        ]);

        if (!Auth::attempt($credentials)) {

            return back()
                ->withErrors([
                    'email' => 'Invalid email or password.'
                ])
                ->onlyInput('email');
        }

        /*
        |--------------------------------------------------------------------------
        | Regenerate Session
        |--------------------------------------------------------------------------
        */

        $request->session()->regenerate();


        /*
        |--------------------------------------------------------------------------
        | Check Account Status
        |--------------------------------------------------------------------------
        */

        if (!auth()->user()->is_active) {

            Auth::logout();

            return back()
                ->withErrors([
                    'email' => 'Your account is inactive.'
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Redirect According To Role
        |--------------------------------------------------------------------------
        */

        if (auth()->user()->role === 'admin') {

            return redirect()->route(
                'admin.dashboard'
            );
        }

        if (auth()->user()->role === 'staff') {

            return redirect('/staff/dashboard');
        }

        if (auth()->user()->role === 'student') {

            return redirect('/student/dashboard');
        }


        Auth::logout();

        return back()
            ->withErrors([
                'email' => 'Invalid user role.'
            ]);
    }


    /*
    |--------------------------------------------------------------------------
    | STUDENT REGISTRATION FORM
    |--------------------------------------------------------------------------
    */

    public function registerForm()
    {
        $courses = Course::where(
            'is_active',
            true
        )
        ->orderBy('name')
        ->get();

        return view(
            'auth.register',
            compact('courses')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | STUDENT REGISTRATION
    |--------------------------------------------------------------------------
    */

    public function register(Request $request)
    {
        $data = $request->validate([

            'name' => [
                'required',
                'string',
                'max:150'
            ],

            'aadhaar_no' => [
                'required',
                'digits:12'
            ],

            'email' => [
                'required',
                'email',
                'unique:users,email'
            ],

            'phone' => [
                'required',
                'digits:10'
            ],

            'password' => [
                'required',
                'confirmed',
                'min:8'
            ],

            'course_id' => [
                'required',
                'exists:courses,id'
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Active Academic Session
        |--------------------------------------------------------------------------
        */

        $session = AcademicSession::where(
            'is_active',
            true
        )->first();

        if (!$session) {

            return back()
                ->withErrors([
                    'course_id' =>
                        'No active academic session is available.'
                ])
                ->withInput();
        }


        /*
        |--------------------------------------------------------------------------
        | Make Sure Course Is Active
        |--------------------------------------------------------------------------
        */

        $course = Course::where(
            'id',
            $data['course_id']
        )
        ->where(
            'is_active',
            true
        )
        ->first();

        if (!$course) {

            return back()
                ->withErrors([
                    'course_id' =>
                        'Selected course is not available.'
                ])
                ->withInput();
        }


        /*
        |--------------------------------------------------------------------------
        | Create Student
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $data,
            $session,
            &$user
        ) {

            /*
            |--------------------------------------------------------------------------
            | User Account
            |--------------------------------------------------------------------------
            */

            $user = User::create([

                'name' =>
                    $data['name'],

                'email' =>
                    $data['email'],

                'phone' =>
                    $data['phone'],

                'password' =>
                    $data['password'],

                'role' =>
                    'student',

                'is_active' =>
                    true,
            ]);


            /*
            |--------------------------------------------------------------------------
            | Registration Number
            |--------------------------------------------------------------------------
            */

            $registrationNo =
                'REG-' .
                now()->format('Y') .
                '-' .
                str_pad(
                    (string) $user->id,
                    6,
                    '0',
                    STR_PAD_LEFT
                );


            /*
            |--------------------------------------------------------------------------
            | Student Profile
            |--------------------------------------------------------------------------
            */

            StudentProfile::create([

                'user_id' =>
                    $user->id,

                'registration_no' =>
                    $registrationNo,

                'course_id' =>
                    $data['course_id'],

                'aadhaar_no' =>
                    $data['aadhaar_no'],
            ]);


            /*
            |--------------------------------------------------------------------------
            | Admission Application
            |--------------------------------------------------------------------------
            */

            AdmissionApplication::create([

                'user_id' =>
                    $user->id,

                'academic_session_id' =>
                    $session->id,

                'course_id' =>
                    $data['course_id'],

                'application_no' =>
                    'APP-' .
                    now()->format('Y') .
                    '-' .
                    str_pad(
                        (string) $user->id,
                        6,
                        '0',
                        STR_PAD_LEFT
                    ),

                'admission_type' =>
                    'New',

                'status' =>
                    'draft',
            ]);

        });


        /*
        |--------------------------------------------------------------------------
        | Login Student Automatically
        |--------------------------------------------------------------------------
        */

        Auth::login($user);

        $request->session()->regenerate();


        return redirect()
            ->route('student.dashboard')
            ->with(
                'success',
                'Registration successful.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}