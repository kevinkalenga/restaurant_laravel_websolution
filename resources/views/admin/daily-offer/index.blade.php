
@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Daily Offer</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>All Daily Offer</h4>

            <div class="card-header-action">
                <a href="{{ route('admin.dayly-offer.create') }}" class="btn btn-primary">
                    Create New
                </a>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-bordered" id="daily-offers-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
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

    $('#daily-offers-table').DataTable({
        processing: true,
        serverSide: true,

        ajax: '{{ route("admin.dayly-offer.index") }}',

        columns: [

            {
                data: 'id',
                name: 'id'
            },

            {
                data: 'image',
                name: 'image',
                orderable: false,
                searchable: false,
                render: function(data) {

                    if (!data) {
                        return '<span class="text-muted">No Image</span>';
                    }

                    return `
                        <img
                            src="${data}"
                            alt="Daily Offer"
                            style="
                                width: 60px;
                                height: 60px;
                                object-fit: cover;
                                border-radius: 5px;
                            "
                        >
                    `;
                }
            },

            {
                data: 'name',
                name: 'name'
            },

            {
                data: 'status',
                name: 'status',
                render: function(data) {

                    return data == 1
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
