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

        <table class="table table-bordered" id="blogs-table">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Category ID</th>
                    <th>Image</th>
                    <th>Title</th>
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

@push('scripts')

<script>
$(function () {

    $('#blogs-table').DataTable({

        processing: true,
        serverSide: true,

        ajax: "{{ route('admin.blogs.index') }}",

        columns: [

            {
                data: 'id',
                name: 'id'
            },

            {
                data: 'user_name',
                name: 'user_name'
            },

            {
                data: 'category_name',
                name: 'category_name'
            },

           {
                data: 'image',
                name: 'image',
                render: function(data) {

                    if (!data) {
                        return '-';
                    }

                    return '<img src="/' + data + '" ' +
                        'alt="Blog Image" ' +
                        'width="80" ' +
                        'height="60" ' +
                        'style="object-fit: cover;">';
                }
            },

            {
                data: 'title',
                name: 'title'
            },

            {
                data: 'slug',
                name: 'slug'
            },

            {
                data: 'status',
                name: 'status',
                render: function(data) {

                    if (data == 1) {
                        return '<span class="badge badge-success">Active</span>';
                    }

                    return '<span class="badge badge-danger">Inactive</span>';
                }
            },

            {
                data: 'created_at',
                name: 'created_at',
                render: function(data) {

                    return new Date(data).toLocaleString('fr-FR', {
                        day: '2-digit',
                        month: '2-digit',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                }
            },

            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }

        ]

    });

});
</script>

@endpush
