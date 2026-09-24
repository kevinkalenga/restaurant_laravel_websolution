@extends('admin.layouts.master')

@section('content')

<section class="section">

```
<div class="section-header">
    <h1>Blog</h1>
</div>

<div class="card card-primary">

    <div class="card-header">
        <h4>All Blogs</h4>

        <div class="card-header-action">
            <a href="{{ route('admin.blogs.create') }}"
               class="btn btn-primary">
                Create New
            </a>
        </div>
    </div>

    <div class="card-body">

        <table class="table table-bordered" id="blog-categories-table">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>

        </table>

    </div>

</div>
```

</section>

@endsection

