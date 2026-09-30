@extends('admin.layouts.master')

@section('content')

<section class="section">


<div class="section-header">
    <h1>Reservations</h1>
</div>

<div class="card card-primary">

    <div class="card-header">
        <h4>All Reservations</h4>
    </div>

    <div class="card-body">

        <table class="table table-bordered table-striped" id="reservation-table">

            <thead>
                <tr>
                    <th>Reservation ID</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Persons</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                {{-- DataTables loads reservations via AJAX --}}
            </tbody>

        </table>

    </div>
</div>
```

</section>

@endsection

@push('scripts')

<script>
$(document).ready(function () {

    $('#reservation-table').DataTable({

        processing: true,
        serverSide: true,

        ajax: "{{ route('admin.reservation.index') }}",

        columns: [
            {
                data: 'reservation_id',
                name: 'reservation_id'
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'phone',
                name: 'phone'
            },
            {
                data: 'date',
                name: 'date'
            },
            {
                data: 'time',
                name: 'time'
            },
            {
                data: 'persons',
                name: 'persons'
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
