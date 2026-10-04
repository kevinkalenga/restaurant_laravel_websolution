```blade
@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Edit Page Builder</h1>

        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item">
                <a href="{{ route('admin.custom-page-builder.index') }}">
                    Custom Page Builder
                </a>
            </div>

            <div class="breadcrumb-item active">
                Edit
            </div>
        </div>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Edit Page</h4>
        </div>

        <div class="card-body">

            <form action="{{ route('admin.custom-page-builder.update', $page->id) }}"
                  method="POST"
                  novalidate>

                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Page Name</label>

                    <input
                        type="text"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $page->name) }}"
                    >

                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Page Content</label>

                    <textarea
                        name="content"
                        class="form-control @error('content') is-invalid @enderror"
                        rows="8"
                    >{{ old('content', $page->content) }}</textarea>

                    @error('content')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Status</label>

                    <select
                        name="status"
                        class="form-control @error('status') is-invalid @enderror"
                    >
                        <option value="1" {{ old('status', $page->status) == 1 ? 'selected' : '' }}>
                            Active
                        </option>

                        <option value="0" {{ old('status', $page->status) == 0 ? 'selected' : '' }}>
                            Inactive
                        </option>
                    </select>

                    @error('status')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    Update
                </button>

                <a href="{{ route('admin.custom-page-builder.index') }}"
                   class="btn btn-secondary">
                    Cancel
                </a>

            </form>

        </div>
    </div>
</section>
@endsection
```
