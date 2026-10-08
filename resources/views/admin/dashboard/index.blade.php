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
</script>
@endpush
@endsection