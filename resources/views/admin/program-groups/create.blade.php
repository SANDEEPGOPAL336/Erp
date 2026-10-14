@extends('admin.layouts.app')

@section('title', 'Add Program Group - College ERP')

@section('content')

<div class="container-fluid">

    <div class="mb-4">

        <h2 class="fw-bold mb-1">
            Add Program Group
        </h2>

        <p class="text-muted mb-0">
            Create a new academic program group
        </p>

    </div>

    <div class="card shadow-sm border-0">

        <div class="card-body">

            <form
                action="{{ route('admin.program-groups.store') }}"
                method="POST"
            >

                @csrf

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">
                            Program Group Name
                        </label>

                        <input
                            type="text"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}"
                            placeholder="Example: UG Program"
                            required
                        >

                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">
                            Code
                        </label>

                        <input
                            type="text"
                            name="code"
                            class="form-control @error('code') is-invalid @enderror"
                            value="{{ old('code') }}"
                            placeholder="Example: UG"
                            required
                        >

                        @error('code')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <div class="col-md-6 mb-3">

                        <div class="form-check mt-2">

                            <input
                                type="checkbox"
                                name="is_active"
                                value="1"
                                id="is_active"
                                class="form-check-input"
                                checked
                            >

                            <label
                                for="is_active"
                                class="form-check-label"
                            >
                                Active
                            </label>

                        </div>

                    </div>

                </div>

                <div class="mt-3">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Save Program Group
                    </button>

                    <a
                        href="{{ route('admin.program-groups.index') }}"
                        class="btn btn-secondary"
                    >
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection