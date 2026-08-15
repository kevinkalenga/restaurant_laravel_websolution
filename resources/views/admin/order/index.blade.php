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



<!-- Modal -->
<div class="modal fade" id="order_model" tabindex="-1" role="dialog" aria-labelledby="order_modal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          
    
             <div class="form-group">
                <label><strong>Payment Status</strong></label>

                <select name="payment_status" class="form-control payment_status">
                    <option value="pending">Pending</option>
                    <option value="completed">Completed</option>
                </select>
            </div>

            <div class="form-group">
                <label><strong>Order Status</strong></label>

                <select name="order_status" class="form-control order_status">
                    <option value="pending">Pending</option>
                    <option value="in_process">In Process</option>
                    <option value="delivered">Delivered</option>
                    <option value="declined">Declined</option>
                </select>
            </div>
    
    
    
       </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button"
                class="btn btn-primary"
                id="save-order-status"
                data-url="">
            Save changes
        </button>
        <!-- <button type="button" class="btn btn-primary" id="save-order-status">Save changes</button> -->
      </div>
    </div>
  </div>
</div>














<style>
    #products-table th.action-column,
    #products-table td.action-column {
        width: 150px !important;
        min-width: 150px !important;
        max-width: 150px !important;
        white-space: nowrap;
        text-align: center;
    }

    #products-table td.action-column a,
    #products-table td.action-column button {
        display: inline-block;
        margin-right: 5px;
    }
</style>
@endsection

@push('scripts') 

<script>
    const currencyIcon = "{{ config('settings.site_currency_icon') }}";
    const currencyPosition = "{{ config('settings.site_currency_icon_position') }}";

    $(function () {

        $('#products-table').DataTable({

            processing: true,
            serverSide: true,
            autoWidth: false,

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

                        return '<span class="badge badge-success">'
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
                    searchable:false,
                    className: 'action-column',
                    width: '150px'
                }

            ]

        });

    });

 
</script>

<script>
    let currentOrderId = null;

    // =========================
    // GET : récupérer les statuts
    // =========================

    $(document).on('click', '.edit-order-status', function () {

        let id = $(this).data('id');

        console.log('ORDER ID =', id);

        if (!id) {
            alert('ID de commande introuvable.');
            return;
        }

        currentOrderId = id;

        let url = '{{ route("admin.orders.status", ":id") }}'
            .replace(':id', id);

        console.log('GET URL =', url);

        $.ajax({
            method: 'GET',
            url: url,

            success: function (response) {

                console.log('RESPONSE =', response);

                $('.payment_status').val(response.payment_status);
                $('.order_status').val(response.order_status);

                $('#order_model').modal('show');
            },

            error: function (xhr) {

                console.log('STATUS =', xhr.status);
                console.log('ERROR =', xhr.responseText);

                alert(
                    'Erreur HTTP ' +
                    xhr.status +
                    '\n\n' +
                    xhr.responseText
                );
            }
        });
    });


    // =========================
    // PUT : mettre à jour les statuts
    // =========================

    // $(document).on('click', '#save-order-status', function () {

    //     console.log('SAVE CLICK');
    //     console.log('ORDER ID =', currentOrderId);

    //     if (!currentOrderId) {
    //         alert('ID de commande introuvable.');
    //         return;
    //     }

    //     let url = '/admin/orders/' + currentOrderId + '/status';

    //     let paymentStatus = $('.payment_status').val();
    //     let orderStatus = $('.order_status').val();

    //     console.log('PUT URL =', url);
    //     console.log('PAYMENT STATUS =', paymentStatus);
    //     console.log('ORDER STATUS =', orderStatus);

    //     $.ajax({
    //         method: 'PUT',
    //         url: url,

    //         data: {
    //             _token: '{{ csrf_token() }}',
    //             payment_status: paymentStatus,
    //             order_status: orderStatus
    //         },

    //         success: function (response) {

    //             console.log('UPDATE RESPONSE =', response);

    //             $('#order_model').modal('hide');

    //             $('#products-table')
    //                 .DataTable()
    //                 .ajax.reload(null, false);

    //         },

    //         error: function (xhr) {

    //             console.log('UPDATE STATUS =', xhr.status);
    //             console.log('UPDATE ERROR =', xhr.responseText);

    //             alert(
    //                 'Erreur HTTP ' +
    //                 xhr.status +
    //                 '\n\n' +
    //                 xhr.responseText
    //             );
    //         }
    //     });
    // });

     
     $(document).off('click', '#save-order-status').on('click', '#save-order-status', function (e) {

        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();

        let url = '/admin/orders/' + currentOrderId + '/status';

        console.log('SAVE URL =', url);

        $.ajax({
            url: url,
            type: 'POST',

            data: {
                _token: '{{ csrf_token() }}',
                _method: 'PUT',
                payment_status: $('.payment_status').val(),
                order_status: $('.order_status').val()
            },

            success: function (response) {

                console.log('SUCCESS =', response);

                $('#order_model').modal('hide');

                $('#products-table')
                    .DataTable()
                    .ajax.reload(null, false);
            },

            error: function (xhr) {

                console.log('ERROR STATUS =', xhr.status);
                console.log('ERROR URL =', xhr.responseURL);
                console.log('ERROR =', xhr.responseText);
            }
        });

    });

</script>


@endpush

