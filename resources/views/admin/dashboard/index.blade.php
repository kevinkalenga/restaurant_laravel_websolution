 @extends('admin.layouts.master')  
   
@section('content')
<section class="section">
          <div class="section-header">
            <h1>Dashboard</h1>
          </div>
          <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                  <i class="fas fa-cart-plus"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Total Orders</h4>
                  </div>
                  <div class="card-body">
                    {{$total_completed_orders}}
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                  <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Total Orders Earnings</h4>
                  </div>
                  <div class="card-body">
                    {{currencyPosition($total_completed_Earnings)}}
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                  <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>This Month Orders</h4>
                  </div>
                  <div class="card-body">
                    {{$thisMonthOrders}}
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                  <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>This Month Earnings</h4>
                  </div>
                  <div class="card-body">
                    {{currencyPosition($total_completed_Earnings)}}
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                  <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>This Year Orders</h4>
                  </div>
                  <div class="card-body">
                    {{$thisYearOrders}}
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                  <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>This Year Earnings</h4>
                  </div>
                  <div class="card-body">
                    {{currencyPosition($thisYearEarnings)}}
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                  <i class="fas fa-users"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Total Users</h4>
                  </div>
                  <div class="card-body">
                    {{$totalUsers}}
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                  <i class="fas fa-user-shield"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Total Admins</h4>
                  </div>
                  <div class="card-body">
                     {{$totalAdmins}}
                  </div>
                </div>
              </div>
            </div>                  
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                  <i class="fas fa-th"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Total Products</h4>
                  </div>
                  <div class="card-body">
                    {{$totalProducts}}
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                  <i class="fas fa-rss"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <hg4>Total Blogs</hg4>
                  </div>
                  <div class="card-body">
                     {{$totalBlogs}}
                  </div>
                </div>
              </div>
            </div>                  
          </div>
    
</section>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Nombre de commandes par menu</h4>
            </div>

            <div class="card-body">
                <canvas id="ordersByMenuChart"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">
                <h4>Dernières commandes</h4>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="dashboard-orders-table">
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
        </div>
    </div>
</div>

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



@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const statistics = @json($statistics);

    const labels = statistics.map(stat => stat.menu_name);
    const data = statistics.map(stat => stat.total_orders);

    new Chart(document.getElementById('ordersByMenuChart'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Nombre de commandes',
                data: data
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    $('#dashboard-orders-table').DataTable({
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

                if (isNaN(price)) return '';

                return '{{ config("settings.site_currency_icon_position") }}' === 'left'
                    ? '{{ config("settings.site_currency_icon") }}' + price.toFixed(2)
                    : price.toFixed(2) + '{{ config("settings.site_currency_icon") }}';
            }
        },
        {
            data: 'discount',
            name: 'discount',
            render: function(data) {
                const price = Number(data);

                if (isNaN(price)) return '';

                return '{{ config("settings.site_currency_icon_position") }}' === 'left'
                    ? '{{ config("settings.site_currency_icon") }}' + price.toFixed(2)
                    : price.toFixed(2) + '{{ config("settings.site_currency_icon") }}';
            }
        },
        {
            data: 'delivery_charge',
            name: 'delivery_charge',
            render: function(data) {
                const price = Number(data);

                if (isNaN(price)) return '';

                return '{{ config("settings.site_currency_icon_position") }}' === 'left'
                    ? '{{ config("settings.site_currency_icon") }}' + price.toFixed(2)
                    : price.toFixed(2) + '{{ config("settings.site_currency_icon") }}';
            }
        },
        {
            data: 'grand_total',
            name: 'grand_total',
            render: function(data) {
                const price = Number(data);

                if (isNaN(price)) return '';

                return '{{ config("settings.site_currency_icon_position") }}' === 'left'
                    ? '{{ config("settings.site_currency_icon") }}' + price.toFixed(2)
                    : price.toFixed(2) + '{{ config("settings.site_currency_icon") }}';
            }
        },
        {
            data: 'payment_method',
            name: 'payment_method'
        },
        {
            data: 'payment_status',
            name: 'payment_status',
            render: function(data) {
                if (data === 'paid') {
                    return '<span class="badge badge-success">Paid</span>';
                }

                return '<span class="badge badge-warning">' + data + '</span>';
            }
        },
        {
            data: 'order_status',
            name: 'order_status',
            render: function(data) {

                let badge = 'badge-warning';

                if (data === 'delivered') {
                    badge = 'badge-success';
                }

                if (data === 'cancelled' || data === 'declined') {
                    badge = 'badge-danger';
                }

                return '<span class="badge ' + badge + '">' +
                    data +
                    '</span>';
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
            searchable: false,
            className: 'action-column',
            width: '150px'
        }
    ]
});
/**************************************************************/

$(document).off('click', '#save-order-status').on('click', '#save-order-status', function (e) {

        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();

        // let url = '/admin/orders/' + currentOrderId + '/status';

         let url = '{{ route("admin.orders.update-status", ":id") }}'
        .replace(':id', currentOrderId);

        console.log('SAVE URL =', url);
        console.log('### POST VERSION ###');

        $.ajax({
            url: url,
            type: 'POST',
            dataType:'json',

            data: {
                _token: '{{ csrf_token() }}',
                payment_status: $('.payment_status').val(),
                order_status: $('.order_status').val()
            },

            success: function (response) {

                console.log('SUCCESS =', response);

                $('#order_model').modal('hide');

                $('#products-table')
                    .DataTable()
                    .ajax.reload(null, false);

                    // Message de confirmation
                    alert(response.message);
            },

            error: function (xhr) {

                console.log('ERROR STATUS =', xhr.status);
                console.log('ERROR URL =', xhr.responseURL);
                console.log('ERROR =', xhr.responseText);
                 alert('Erreur lors de la mise à jour du statut.');
            }
        });

    });

    // Delete order 
    $(document).on('click', '.delete-item', function (e) {

            e.preventDefault();

            let url = $(this).attr('href');

            console.log('DELETE URL =', url);

            if (!confirm('Are you sure you want to delete this order?')) {
                return;
            }

            $.ajax({
                url: url,
                type: 'DELETE',

                data: {
                    _token: '{{ csrf_token() }}'
                },

                success: function (response) {

                    console.log('DELETE SUCCESS =', response);

                    $('#products-table')
                        .DataTable()
                        .ajax.reload(null, false);
                },

                error: function (xhr) {

                    console.log('DELETE ERROR =', xhr.status);
                    console.log(xhr.responseText);

                    alert('Error deleting order.');
                }
            });

    });


 
let currentOrderId = null;


/* =========================================================
   MODIFIER LE STATUT D'UNE COMMANDE
   ========================================================= */

$(document).on('click', '.edit-order-status', function (e) {

    e.preventDefault();

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

            console.log('GET ERROR STATUS =', xhr.status);
            console.log('GET ERROR =', xhr.responseText);

            alert(
                'Erreur lors de la récupération du statut.\n\n' +
                'HTTP ' + xhr.status
            );
        }
    });
});


/* =========================================================
   ENREGISTRER LE NOUVEAU STATUT
   ========================================================= */

$(document)
    .off('click', '#save-order-status')
    .on('click', '#save-order-status', function (e) {

        e.preventDefault();

        if (!currentOrderId) {
            alert('Aucune commande sélectionnée.');
            return;
        }

        let url = '{{ route("admin.orders.update-status", ":id") }}'
            .replace(':id', currentOrderId);

        console.log('SAVE URL =', url);

        let paymentStatus = $('.payment_status').val();
        let orderStatus = $('.order_status').val();

        console.log('PAYMENT STATUS =', paymentStatus);
        console.log('ORDER STATUS =', orderStatus);

        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',

            data: {
                _token: '{{ csrf_token() }}',
                payment_status: paymentStatus,
                order_status: orderStatus
            },

            success: function (response) {

                console.log('SAVE SUCCESS =', response);

                $('#order_model').modal('hide');

                /*
                 * IMPORTANT :
                 * On recharge le DataTable du Dashboard,
                 * pas products-table.
                 */
                $('#dashboard-orders-table')
                    .DataTable()
                    .ajax.reload(null, false);

                alert(response.message);

                currentOrderId = null;
            },

            error: function (xhr) {

                console.log('SAVE ERROR STATUS =', xhr.status);
                console.log('SAVE ERROR =', xhr.responseText);

                /*
                 * Affiche les erreurs Laravel de validation
                 * si disponibles.
                 */
                if (xhr.responseJSON && xhr.responseJSON.errors) {

                    console.log(
                        'VALIDATION ERRORS =',
                        xhr.responseJSON.errors
                    );
                }

                alert(
                    'Erreur lors de la mise à jour du statut.\n\n' +
                    'HTTP ' + xhr.status
                );
            }
        });
    });


/* =========================================================
   SUPPRIMER UNE COMMANDE
   ========================================================= */

$(document).on('click', '.delete-item', function (e) {

    e.preventDefault();

    let url = $(this).attr('href');

    console.log('DELETE URL =', url);

    if (!confirm('Are you sure you want to delete this order?')) {
        return;
    }

    $.ajax({
        url: url,
        type: 'DELETE',

        data: {
            _token: '{{ csrf_token() }}'
        },

        success: function (response) {

            console.log('DELETE SUCCESS =', response);

            $('#dashboard-orders-table')
                .DataTable()
                .ajax.reload(null, false);

            alert(response.message);
        },

        error: function (xhr) {

            console.log('DELETE ERROR =', xhr.status);
            console.log('DELETE ERROR RESPONSE =', xhr.responseText);

            alert(
                'Error deleting order.\n\n' +
                'HTTP ' + xhr.status
            );
        }
    });
});




</script>
@endpush




@endsection


