@extends('admin.layouts.master')

@section('content')

<section class="section">
    <div class="section-header">
        <h1>Product Reviews</h1>
    </div>


<div class="card card-primary">
    <div class="card-header">
        <h4>All Reviews</h4>
    </div>

    <div class="card-body">
        <table class="table table-bordered" id="reviews-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Product</th>
                    <th>Rating</th>
                    <th>Review</th>
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
        $('#reviews-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.product-reviews.index') }}",
            columns: [
                {
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'user',
                    name: 'user'
                },
                {
                    data: 'product',
                    name: 'product'
                },
                {
                    data: 'rating',
                    name: 'rating',
                    orderable: false
                },
                {
                    data: 'review',
                    name: 'review'
                },
                {
                    data: 'status',
                    name: 'status',
                    orderable: false
                },
                { data: 'created_at', name: 'created_at',
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
    
    //Update
     
    $(document).on('click', '.toggle-review-status', function () {

        let id = $(this).data('id');

        $.ajax({
            url: "{{ url('admin/product-reviews') }}/" + id + "/status",
            type: "POST",

            data: {
                _token: "{{ csrf_token() }}",
                _method: "PUT"
            },

            success: function (response) {

                alert(response.message);

                $('#reviews-table').DataTable().ajax.reload(null, false);
            },

            error: function (xhr) {

                console.log('STATUS:', xhr.status);
                console.log('RESPONSE:', xhr.responseText);

                alert(xhr.responseText);
            }
        });

    });

    //Delete

    $(document).on('click', '.delete-review', function () {

        let id = $(this).data('id');

        if (!confirm('Are you sure you want to delete this review?')) {
            return;
        }

        $.ajax({
            url: "{{ url('admin/product-reviews') }}/" + id,
            type: "POST",

            data: {
                _token: "{{ csrf_token() }}",
                _method: "DELETE"
            },

            success: function (response) {

                alert(response.message);

                $('#reviews-table').DataTable().ajax.reload(null, false);
            },

            error: function (xhr) {

                console.log('STATUS:', xhr.status);
                console.log('RESPONSE:', xhr.responseText);

                alert(xhr.responseText);
            }
        });

    });




</script>

@endpush
