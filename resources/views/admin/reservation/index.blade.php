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
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                {{-- DataTables loads reservations via AJAX --}}
            </tbody>

        </table>

    </div>
</div>


</section>

<!-- Edit Reservation Modal -->
<div class="modal fade" id="editReservationModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit Reservation</h5>

                <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="editReservationForm">

                <div class="modal-body">

                    <input type="hidden" id="reservation_id">

                    <div class="form-group">
                        <label>Name</label>
                        <input type="text"
                               class="form-control"
                               id="reservation_name"
                               name="name">
                    </div>

                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text"
                               class="form-control"
                               id="reservation_phone"
                               name="phone">
                    </div>

                    <div class="form-group">
                        <label>Date</label>
                        <input type="date"
                               class="form-control"
                               id="reservation_date"
                               name="date">
                    </div>

                    <div class="form-group">
                        <label>Time</label>
                        <input type="text"
                               class="form-control"
                               id="reservation_time"
                               name="time">
                    </div>

                    <div class="form-group">
                        <label>Persons</label>
                        <input type="number"
                               class="form-control"
                               id="reservation_persons"
                               name="persons"
                               min="1">
                    </div>

                    <div class="form-group">
                        <label>Status</label>

                        <select class="form-control"
                                id="reservation_status"
                                name="status">

                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>

                        </select>
                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal">
                        Close
                    </button>

                    <button type="submit"
                            class="btn btn-primary">
                        Save changes
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>

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
               data:'created_at',
               name:'created_at'
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


$(document).on('click', '.edit-reservation', function () {

    let id = $(this).data('id');

    $.ajax({
        url: "{{ url('admin/reservation') }}/" + id + "/edit",
        type: "GET",

        success: function (response) {

            let reservation = response.reservation;

            $('#reservation_id').val(reservation.id);
            $('#reservation_name').val(reservation.name);
            $('#reservation_phone').val(reservation.phone);
            $('#reservation_date').val(reservation.date);
            $('#reservation_time').val(reservation.time);
            $('#reservation_persons').val(reservation.persons);
            $('#reservation_status').val(reservation.status);

            $('#editReservationModal').modal('show');
        },

        error: function (xhr) {

            console.log(xhr.responseText);

        }
    });

});

$(document).on('submit', '#editReservationForm', function (e) {

    e.preventDefault();

    let id = $('#reservation_id').val();

    console.log('Update reservation ID:', id);

    $.ajax({
        url: "{{ url('admin/reservation') }}/" + id,
        type: "POST",

        data: {
            _token: "{{ csrf_token() }}",
            _method: "PUT",

            name: $('#reservation_name').val(),
            phone: $('#reservation_phone').val(),
            date: $('#reservation_date').val(),
            time: $('#reservation_time').val(),
            persons: $('#reservation_persons').val(),
            status: $('#reservation_status').val()
        },

        success: function (response) {

            console.log(response);

            $('#editReservationModal').modal('hide');

            $('#reservation-table').DataTable().ajax.reload(null, false);

            alert(response.message);
        },

        error: function (xhr) {

             console.log('STATUS:', xhr.status);
            console.log('RESPONSE:', xhr.responseText);

            alert(xhr.responseText);

        }
    });

});

$(document).on('click', '.delete-reservation', function () {

    let id = $(this).data('id');

    if (!confirm('Are you sure you want to delete this reservation?')) {
        return;
    }

    $.ajax({
        url: "{{ url('admin/reservation') }}/" + id,
        type: "POST",

        data: {
            _token: "{{ csrf_token() }}",
            _method: "DELETE"
        },

        success: function (response) {

            alert(response.message);

            $('#reservation-table').DataTable().ajax.reload(null, false);
        },

        error: function (xhr) {

            console.log(xhr.status);
            console.log(xhr.responseText);

        }
    });

});

</script>

@endpush
