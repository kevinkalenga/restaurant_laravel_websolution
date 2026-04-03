@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Category</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('admin.category.index') }}">Categories</a></div>
            <div class="breadcrumb-item active">Edit</div>
        </div>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Edit Category</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.category.update', $category->id) }}" method="POST" novalidate>
                @csrf
                @method('PUT')

                @if(session('success'))
                  <div class="alert alert-success">
                     {{ session('success') }}
                  </div>
                @endif

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}">
                </div>

                <div class="form-group">
                    <label>Show At Home</label>
                    <select name="show_at_home" class="form-control">
                        <option value="1" {{ $category->show_at_home ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ !$category->show_at_home ? 'selected' : '' }}>No</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" class="form-control">
                        <option value="1" {{ $category->status ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ !$category->status ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</section>
@endsection