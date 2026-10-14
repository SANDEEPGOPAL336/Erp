@extends('admin.layouts.app')

@section('title', 'Program Groups - College ERP')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Program Groups</h2>
            <p class="text-muted mb-0">
                Manage academic program groups
            </p>
        </div>

        <a href="{{ route('admin.program-groups.create') }}"
           class="btn btn-primary">
            + Add Program Group
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Please correct the following:</strong>

            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">
                Academic Program Groups
            </h5>
        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>
                            <th width="70">#</th>
                            <th>Program Group</th>
                            <th>Code</th>
                            <th>Departments</th>
                            <th>Status</th>
                            <th width="180">Action</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($programGroups as $group)

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>

                                <td>
                                    <strong>
                                        {{ $group->name }}
                                    </strong>
                                </td>

                                <td>
                                    <span class="badge bg-light text-dark">
                                        {{ $group->code }}
                                    </span>
                                </td>

                                <td>
                                    <span class="badge bg-info">
                                        {{ $group->departments_count }}
                                    </span>
                                </td>

                                <td>

                                    @if($group->is_active)

                                        <span class="badge bg-success">
                                            Active
                                        </span>

                                    @else

                                        <span class="badge bg-secondary">
                                            Inactive
                                        </span>

                                    @endif

                                </td>

                                <td>

                                    <div class="d-flex gap-1">

                                        <a href="{{ route('admin.program-groups.edit', $group) }}"
                                           class="btn btn-sm btn-outline-primary">
                                            Edit
                                        </a>

                                        <form
                                            action="{{ route('admin.program-groups.toggle', $group) }}"
                                            method="POST"
                                            class="d-inline"
                                        >

                                            @csrf
                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                class="btn btn-sm {{ $group->is_active ? 'btn-outline-danger' : 'btn-outline-success' }}"
                                            >
                                                {{ $group->is_active ? 'Disable' : 'Enable' }}
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6"
                                    class="text-center py-5 text-muted">

                                    No Program Groups found.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>
    </div>

</div>

@endsection