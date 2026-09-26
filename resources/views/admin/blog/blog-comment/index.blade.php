@extends('admin.layouts.master')

@section('content')

<section class="section">

```
<div class="section-header">
    <h1>Blog Comments</h1>
</div>

<div class="card card-primary">

    <div class="card-header">
        <h4>All Comments</h4>
    </div>

    <div class="card-body">

        <table class="table table-bordered" id="comments-table">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Blog</th>
                    <th>Comment</th>
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

    $('#comments-table').DataTable({

        processing: true,
        serverSide: true,

        ajax: "{{ route('admin.blogs.comments.index') }}",

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
                data: 'blog_title',
                name: 'blog_title'
            },

            {
                data: 'comment',
                name: 'comment',
                render: function(data) {

                    if (!data) {
                        return '-';
                    }

                    return data.length > 100
                        ? data.substring(0, 100) + '...'
                        : data;
                }
            },

            {
                data: 'status',
                name: 'status',
                render: function(data) {

                    if (data == 1) {
                        return '<span class="badge badge-success">Approved</span>';
                    }

                    return '<span class="badge badge-warning">Pending</span>';
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
