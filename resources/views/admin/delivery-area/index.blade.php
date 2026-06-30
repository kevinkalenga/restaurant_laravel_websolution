@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Delivery Areas</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>All Delivery Areas</h4>
            <div class="card-header-action">
                <a href="{{ route('admin.delivery-area.create') }}" class="btn btn-primary">
                    Create New
                </a>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-bordered" id="delivery-areas-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Area Name</th>
                        <th>Min Delivery Time</th>
                        <th>Max Delivery Time</th>
                        <th>Delivery Fee</th>
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
    const currencyIcon = "{{ config('settings.site_currency_icon') }}";
    const currencyPosition = "{{ config('settings.site_currency_icon_position') }}";
    $('#delivery-areas-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("admin.delivery-area.index") }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'area_name', name: 'area_name' },
            { data: 'min_delivery_time', name: 'min_delivery_time' },
            { data: 'max_delivery_time', name: 'max_delivery_time' },
            {
                data: 'delivery_fee',
                name: 'delivery_fee',
                render: function(data) {
                    const price = Number(data);
                    if (isNaN(price)) return '';

                    return currencyPosition === 'left'
                        ? currencyIcon + price.toFixed(2)
                        : price.toFixed(2) + currencyIcon;
                }
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