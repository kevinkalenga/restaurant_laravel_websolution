@extends('admin.layouts.master')  

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Orders</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>All Orders</h4>
           
        </div>

        <div class="card-body">
            <table class="table table-bordered" id="products-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Invoice ID</th>
                        <th>Customer</th>
                        <th>Product Qty</th>
                        <th>Address</th>
                        <th>Subtotal</th>
                        <th>Discount</th>
                        <th>Delivery Charge</th>
                        <th>Grand Total</th>
                        <th>Payment Method</th>
                        <th>Payment Status</th>
                        <th>Order Status</th>
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
    const currencyIcon = "{{ config('settings.site_currency_icon') }}";
    const currencyPosition = "{{ config('settings.site_currency_icon_position') }}";

    $(function () {

        $('#products-table').DataTable({

            processing: true,
            serverSide: true,

            ajax: '{{ route("admin.orders.index") }}',

            columns: [

                { 
                    data: 'id',
                    name: 'id'
                },

                { 
                    data: 'invoice_id',
                    name: 'invoice_id'
                },

                { 
                    data: 'user.name',
                    name: 'user.name'
                },

                { 
                    data: 'product_qty',
                    name: 'product_qty'
                },

                { 
                    data: 'address',
                    name: 'address'
                },

                {
                    data: 'subtotal',
                    name: 'subtotal',
                    render: function(data) {

                        const price = Number(data);

                        if(isNaN(price)) return '';

                        return currencyPosition === 'left'
                            ? currencyIcon + price.toFixed(2)
                            : price.toFixed(2) + currencyIcon;
                    }
                },


                {
                    data: 'discount',
                    name: 'discount',
                    render: function(data) {

                        const price = Number(data);

                        if(isNaN(price)) return '';

                        return currencyPosition === 'left'
                            ? currencyIcon + price.toFixed(2)
                            : price.toFixed(2) + currencyIcon;
                    }
                },


                {
                    data: 'delivery_charge',
                    name: 'delivery_charge',
                    render: function(data) {

                        const price = Number(data);

                        if(isNaN(price)) return '';

                        return currencyPosition === 'left'
                            ? currencyIcon + price.toFixed(2)
                            : price.toFixed(2) + currencyIcon;
                    }
                },


                {
                    data: 'grand_total',
                    name: 'grand_total',
                    render: function(data) {

                        const price = Number(data);

                        if(isNaN(price)) return '';

                        return currencyPosition === 'left'
                            ? currencyIcon + price.toFixed(2)
                            : price.toFixed(2) + currencyIcon;
                    }
                },


                {
                    data: 'payment_method',
                    name: 'payment_method'
                },


                {
                    data: 'payment_status',
                    name: 'payment_status',
                    render:function(data){

                        if(data == 'paid'){
                            return '<span class="badge badge-success">Paid</span>';
                        }

                        return '<span class="badge badge-warning">'
                            + data +
                        '</span>';
                    }
                },


                {
                    data:'order_status',
                    name:'order_status',
                    render:function(data){

                        let badge = 'badge-warning';

                        if(data == 'delivered'){
                            badge = 'badge-success';
                        }

                        if(data == 'cancelled'){
                            badge = 'badge-danger';
                        }

                        return '<span class="badge '+badge+'">'
                            + data +
                        '</span>';
                    }
                },


                {
                    data:'created_at',
                    name:'created_at',
                    render:function(data){

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
                    data:'action',
                    name:'action',
                    orderable:false,
                    searchable:false
                }

            ]

        });

    });
</script>

@endpush

