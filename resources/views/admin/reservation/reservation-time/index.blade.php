
@extends('admin.layouts.master')

@section('content')

<section class="section">

    <div class="section-header">
        <h1>Reservation Times</h1>
    </div>

    <div class="card card-primary">

        <div class="card-header">
            <h4>All Times</h4>

            <div class="card-header-action">
                <a href="{{ route('admin.reservation-time.create') }}"
                   class="btn btn-primary">
                    Create New
                </a>
            </div>
        </div>

        <div class="card-body">

            <table class="table table-bordered" id="reservation-times-table">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Status</th>
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

    $('#reservation-times-table').DataTable({
        processing: true,
        serverSide: true,

        ajax: "{{ route('admin.reservation-time.index') }}",

        columns: [
            {
                data: 'id',
                name: 'id'
            },
            {
                data: 'start_time',
                name: 'start_time'
            },
            {
                data: 'end_time',
                name: 'end_time'
            },
            {
                data: 'status',
                name: 'status',
                orderable: false,
                searchable: false
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

