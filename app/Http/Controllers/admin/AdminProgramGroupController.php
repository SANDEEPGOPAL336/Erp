<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramGroup;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminProgramGroupController extends Controller
{
    /**
     * Display all program groups.
     */
    public function index()
    {
        $programGroups = ProgramGroup::withCount('departments')
            ->orderBy('name')
            ->get();

        return view('admin.program-groups.index', compact('programGroups'));
    }

    /**
     * Show create form.
     */
    public function create()
    {
        return view('admin.program-groups.create');
    }

    /**
     * Store a new program group.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'code' => [
                'required',
                'string',
                'max:50',
                'alpha_dash',
                'unique:program_groups,code',
            ],
        ]);

        ProgramGroup::create([
            'name' => $validated['name'],
            'code' => strtoupper($validated['code']),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.program-groups.index')
            ->with('success', 'Program Group added successfully.');
    }

    /**
     * Show edit form.
     */
    public function edit(ProgramGroup $programGroup)
    {
        return view(
            'admin.program-groups.edit',
            compact('programGroup')
        );
    }

    /**
     * Update a program group.
     */
    public function update(
        Request $request,
        ProgramGroup $programGroup
    ) {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'code' => [
                'required',
                'string',
                'max:50',
                'alpha_dash',
                Rule::unique('program_groups', 'code')
                    ->ignore($programGroup->id),
            ],
        ]);

        $programGroup->update([
            'name' => $validated['name'],
            'code' => strtoupper($validated['code']),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.program-groups.index')
            ->with('success', 'Program Group updated successfully.');
    }

    /**
     * Activate / deactivate a program group.
     */
    public function toggle(ProgramGroup $programGroup)
    {
        $programGroup->update([
            'is_active' => ! $programGroup->is_active,
        ]);

        return redirect()
            ->route('admin.program-groups.index')
            ->with(
                'success',
                $programGroup->is_active
                    ? 'Program Group activated successfully.'
                    : 'Program Group deactivated successfully.'
            );
    }
}