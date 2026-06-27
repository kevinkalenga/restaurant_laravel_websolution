@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Coupons</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>All Coupons</h4>
            <div class="card-header-action">
                <a href="{{ route('admin.coupon.create') }}" class="btn btn-primary">
                    Create New
                </a>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-bordered" id="coupons-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Coupon Code</th>
                        <th>Quantity</th>
                        <th>Minimum Purchase</th>
                        <th>Expire Date</th>
                        <th>Discount Type</th>
                        <th>Discount</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Updated At</th>
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

const currencyIcon = "{{ config('settings.site_currency_icon') }}";
const currencyPosition = "{{ config('settings.site_currency_icon_position') }}";

$(function () {

    $('#coupons-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("admin.coupon.index") }}',

        columns: [

            { data: 'id', name: 'id' },

            { data: 'name', name: 'name' },

            { data: 'code', name: 'code' },

            { data: 'quantity', name: 'quantity' },

            {
                data: 'min_purchase_amount',
                name: 'min_purchase_amount',
                render: function(data){

                    const amount = Number(data);

                    if(isNaN(amount)) return '';

                    return currencyPosition === 'left'
                        ? currencyIcon + amount.toFixed(2)
                        : amount.toFixed(2) + currencyIcon;
                }
            },

            { data: 'expire_date', name: 'expire_date' },

            {
                data: 'discount_type',
                name: 'discount_type',
                render: function(data){

                    return data === 'percent'
                        ? '<span class="badge badge-info">Percent</span>'
                        : '<span class="badge badge-primary">Amount</span>';
                }
            },

            {
                data: 'discount',
                name: 'discount',
                render: function(data, type, row){

                    if(row.discount_type === 'percent'){
                        return data + '%';
                    }

                    const amount = Number(data);

                    if(isNaN(amount)) return '';

                    return currencyPosition === 'left'
                        ? currencyIcon + amount.toFixed(2)
                        : amount.toFixed(2) + currencyIcon;
                }
            },

            {
                data: 'status',
                name: 'status',
                render: function(data){

                    return data == 1
                        ? '<span class="badge badge-success">Active</span>'
                        : '<span class="badge badge-danger">Inactive</span>';
                }
            },

            {
                data: 'created_at',
                name: 'created_at',
                render: function(data){

                    return new Date(data).toLocaleString('fr-FR',{
                        day:'2-digit',
                        month:'2-digit',
                        year:'numeric',
                        hour:'2-digit',
                        minute:'2-digit'
                    });
                }
            },

            {
                data: 'updated_at',
                name: 'updated_at',
                render: function(data){

                    return new Date(data).toLocaleString('fr-FR',{
                        day:'2-digit',
                        month:'2-digit',
                        year:'numeric',
                        hour:'2-digit',
                        minute:'2-digit'
                    });
                }
            },

            {
                data: 'action',
                name: 'action',
                orderable:false,
                searchable:false
            }

        ]
    });

});

</script>
@endpush