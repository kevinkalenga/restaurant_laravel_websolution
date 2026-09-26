@extends('admin.layouts.master')

@section('content')

<section class="section">

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
                orderable: false,
                searchable: false,

                render: function(data, type, row) {

                    if (data == 1) {

                        return `
                            <button type="button"
                                    class="btn btn-sm btn-success comment-status"
                                    data-id="${row.id}"
                                    data-status="0">
                                Approved
                            </button>
                        `;

                    }

                    return `
                        <button type="button"
                                class="btn btn-sm btn-warning comment-status"
                                data-id="${row.id}"
                                data-status="1">
                            Disapproved
                        </button>
                    `;
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


    // Update comment status

    $(document).on('click', '.comment-status', function () {

        let button = $(this);
        let id = button.data('id');
        let status = button.data('status');

        $.ajax({

            url: "{{ url('admin/blogs/comments') }}/" + id + "/status",

            type: "PATCH",

            data: {
                status: status,
                _token: "{{ csrf_token() }}"
            },

            success: function (response) {

                $('#comments-table')
                    .DataTable()
                    .ajax
                    .reload(null, false);

                iziToast.success({
                    title: 'Success',
                    message: response.message,
                    position: 'topRight'
                });

            },

            error: function () {

                iziToast.error({
                    title: 'Error',
                    message: 'Unable to update comment status.',
                    position: 'topRight'
                });

            }

        });

    });

});
</script>

@endpush