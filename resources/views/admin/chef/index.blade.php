```blade
@extends('admin.layouts.master')

@section('content')
<section class="section">

    <div class="section-header">
        <h1>Chefs</h1>
    </div>

    <div class="card card-primary">

        <div class="card-header">
            <h4>All Chefs</h4>

            <div class="card-header-action">
                <a href="{{ route('admin.banner-slider.create') }}"
                   class="btn btn-primary">
                    Create New
                </a>
            </div>
        </div>

        <div class="card-body">

            <table class="table table-bordered" id="banner-sliders-table">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Banner</th>
                        <th>Title</th>
                        <th>Sub Title</th>
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

    $('#banner-sliders-table').DataTable({

        processing: true,
        serverSide: true,

        ajax: '{{ route("admin.banner-slider.index") }}',

        columns: [

            {
                data: 'id',
                name: 'id'
            },

            {
                data: 'banner',
                name: 'banner',
                orderable: false,
                searchable: false,

                render: function(data, type, row) {
                    return '<img src="' + data + '" width="100">';
                }
            },

            {
                data: 'title',
                name: 'title'
            },

            {
                data: 'sub_title',
                name: 'sub_title'
            },

            {
                data: 'status',
                name: 'status',

                render: function(data) {

                    return data
                        ? '<span class="badge badge-success">Active</span>'
                        : '<span class="badge badge-danger">Inactive</span>';

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

