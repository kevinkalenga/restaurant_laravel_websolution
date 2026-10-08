```blade
@extends('admin.layouts.master')

@section('content')

<section class="section">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">

                <div class="card">

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Opening Hours</h4>

                        <button type="button"
                                class="btn btn-primary"
                                id="add-opening-hour">
                            <i class="fas fa-plus"></i>
                            Add Opening Hour
                        </button>
                    </div>

                    <div class="card-body">

                        <div class="table-responsive">

                            <table class="table table-bordered table-striped"
                                   id="opening-hours-table">

                                <thead>
                                    <tr>
                                        <th>Day</th>
                                        <th>Opening</th>
                                        <th>Closing</th>
                                        <th>Status</th>
                                        <th width="150px">Action</th>
                                    </tr>
                                </thead>

                            </table>

                        </div>

                    </div>

                </div>

            </div>
        </div>

    </div>
</section>

@endsection

<!-- Opening Hours Modal -->
<div class="modal fade"
     id="openingHourModal"
     tabindex="-1"
     role="dialog"
     aria-labelledby="openingHourModalLabel"
     aria-hidden="true">

    <div class="modal-dialog" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="openingHourModalLabel">
                    Edit Opening Hours
                </h5>

                <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>

            <form id="openingHourForm">

                @csrf

                <div class="modal-body">

                    <input type="hidden"
                           id="opening_hour_id"
                           name="opening_hour_id">

                    <div class="form-group">
                        <label for="day">Day</label>

                        <select name="day"
                                id="day"
                                class="form-control">

                            <option value="monday">Monday</option>
                            <option value="tuesday">Tuesday</option>
                            <option value="wednesday">Wednesday</option>
                            <option value="thursday">Thursday</option>
                            <option value="friday">Friday</option>
                            <option value="saturday">Saturday</option>
                            <option value="sunday">Sunday</option>

                        </select>
                    </div>


                    <div class="form-group">
                        <label for="open_time">Opening Time</label>

                        <input type="time"
                               name="open_time"
                               id="open_time"
                               class="form-control">
                    </div>


                    <div class="form-group">
                        <label for="close_time">Closing Time</label>

                        <input type="time"
                               name="close_time"
                               id="close_time"
                               class="form-control">
                    </div>


                    <div class="form-group">

                        <div class="custom-control custom-switch">

                            <input type="checkbox"
                                   name="is_closed"
                                   value="1"
                                   class="custom-control-input"
                                   id="is_closed">

                            <label class="custom-control-label"
                                   for="is_closed">
                                Closed
                            </label>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal">
                        Cancel
                    </button>

                    <button type="submit"
                            class="btn btn-primary"
                            id="save-opening-hour">
                        Save changes
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>



@push('scripts')
<script>

$(document).ready(function () {

    let openingHoursTable = $('#opening-hours-table').DataTable({

        processing: true,
        serverSide: true,
        autoWidth: false,

        ajax: "{{ route('admin.opening-hours.index') }}",

        columns: [

            {
                data: 'day',
                name: 'day'
            },

            {
                data: 'open_time',
                name: 'open_time'
            },

            {
                data: 'close_time',
                name: 'close_time'
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


    // Edit Opening Hour
    $(document).on('click', '.edit-opening-hour', function () {

        let id = $(this).data('id');

        let url = "{{ route('admin.opening-hours.edit', ':id') }}"
            .replace(':id', id);

        $.ajax({

            method: 'GET',
            url: url,

            success: function (response) {

                $('#opening_hour_id').val(response.id);
                $('#day').val(response.day);
                $('#open_time').val(response.open_time);
                $('#close_time').val(response.close_time);

                $('#is_closed').prop(
                    'checked',
                    response.is_closed
                );

                $('#openingHourModal').modal('show');
            },

            error: function (xhr) {

                console.log(xhr.responseText);

                iziToast.error({
                    title: 'Error',
                    message: 'Unable to load opening hours.',
                    position: 'topRight'
                });

            }

        });

    });


    // Update Opening Hour
    $('#openingHourForm').on('submit', function (e) {

        e.preventDefault();

        let id = $('#opening_hour_id').val();

        let url = "{{ route('admin.opening-hours.update', ':id') }}"
            .replace(':id', id);

        $.ajax({

            method: 'PUT',
            url: url,

            data: {
                _token: "{{ csrf_token() }}",
                day: $('#day').val(),

                open_time: $('#open_time').val()
                    ? $('#open_time').val().substring(0, 5)
                    : null,

                close_time: $('#close_time').val()
                    ? $('#close_time').val().substring(0, 5)
                    : null,

                is_closed: $('#is_closed').is(':checked') ? 1 : 0
            },

            success: function (response) {

                $('#openingHourModal').modal('hide');

                openingHoursTable
                    .ajax
                    .reload(null, false);

                iziToast.success({
                    title: 'Success',
                    message: response.message,
                    position: 'topRight'
                });

            },

            error: function (xhr) {

                console.log(xhr.responseText);

                if (
                    xhr.status === 422 &&
                    xhr.responseJSON &&
                    xhr.responseJSON.errors
                ) {

                    $.each(
                        xhr.responseJSON.errors,
                        function (field, messages) {

                            $.each(messages, function (index, error) {

                                iziToast.error({
                                    title: 'Error',
                                    message: error,
                                    position: 'topRight'
                                });

                            });

                        }
                    );

                    return;
                }

                iziToast.error({
                    title: 'Error',
                    message: 'Unable to update opening hours.',
                    position: 'topRight'
                });

            }

        });

    });

});

</script>


@endpush
