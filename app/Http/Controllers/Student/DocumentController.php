<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\StudentDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $profile = $request->user()->studentProfile;

        if (!$profile) {
            abort(404, 'Student profile not found.');
        }

        $documents = StudentDocument::where(
            'student_profile_id',
            $profile->id
        )
        ->where('is_active', true)
        ->latest()
        ->get();

        return view(
            'student.documents',
            compact(
                'profile',
                'documents'
            )
        );
    }

    public function store(Request $request)
    {
        $profile = $request->user()->studentProfile;

        if (!$profile) {
            abort(404, 'Student profile not found.');
        }

        $data = $request->validate([
            'document_name' => [
                'required',
                'string',
                'max:150',
            ],

            'document' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:2048',
            ],
        ]);

        $path = $request->file('document')
            ->store(
                'student-documents',
                'public'
            );

        StudentDocument::create([
            'student_profile_id' =>
                $profile->id,

            'document_name' =>
                $data['document_name'],

            'file_path' =>
                $path,

            'is_active' =>
                true,
        ]);

        return back()->with(
            'success',
            'Document uploaded successfully.'
        );
    }

    public function disable(
        Request $request,
        StudentDocument $document
    ) {
        $profile = $request->user()->studentProfile;

        abort_unless(
            $document->student_profile_id === $profile->id,
            403
        );

        $document->update([
            'is_active' => false,
        ]);

        return back()->with(
            'success',
            'Document disabled.'
        );
    }
}