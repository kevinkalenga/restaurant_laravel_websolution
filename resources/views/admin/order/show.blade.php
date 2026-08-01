@extends('admin.layouts.master')

@section('content')

<section class="section">

    <div class="section-header">
        <h1>Order Preview</h1>

        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">
                <a href="#">Dashboard</a>
            </div>

            <div class="breadcrumb-item">
                Invoice
            </div>
        </div>

    </div>


    <div class="section-body">

        <div class="invoice">

            <div class="invoice-print">


                <div class="row">

                    <div class="col-lg-12">

                        <div class="invoice-title">

                            <h2>Invoice</h2>

                            <div class="invoice-number">
                                Order #{{ $order->invoice_id }}
                            </div>

                        </div>

                        <hr>


                        <div class="row">

                            <div class="col-md-6">

                                <address>

                                    <strong>Deliver To:</strong>
                                    <br>

                                    <strong>Name:</strong>
                                    {{ $order->user->name ?? 'Guest' }}

                                    <br>

                                    <strong>Email:</strong>
                                    {{ $order->user->email ?? '' }}

                                    <br>

                                    <strong>Address:</strong>
                                    {{ $order->address }}
                                    <br>
                                     <strong>Delivery Area:</strong>
                                    {{ $order->deliveryArea->area_name ?? 'N/A' }}

                                    <br>

                                    <strong>Estimated Delivery:</strong>
                                    {{ $order->deliveryArea->min_delivery_time ?? '-' }}
                                    -
                                    {{ $order->deliveryArea->max_delivery_time ?? '-' }}

                                </address>

                            </div>


                            <div class="col-md-6 text-md-right">

                                <address>

                                    <strong>Order Status:</strong>
                                    <br>

                                    <span class="badge badge-warning">{{ ucfirst($order->order_status) }}</span>

                                    <br><br>

                                    <strong>Payment Status:</strong>
                                    <br>

                                    <span class="badge badge-success">{{ ucfirst($order->payment_status) }}</span>

                                </address>

                            </div>

                        </div>



                        <div class="row">

                            <div class="col-md-6">

                                <address>

                                    <strong>Payment Method:</strong>
                                    <br>

                                    {{ $order->payment_method ?? 'N/A' }}

                                </address>

                            </div>


                            <div class="col-md-6 text-md-right">

                                <address>

                                    <strong>Order Date:</strong>
                                    <br>

                                    {{ $order->created_at->format('d/m/Y H:i') }}

                                </address>

                            </div>

                        </div>


                    </div>

                </div>





                <div class="row mt-4">


                    <div class="col-md-12">


                        <div class="section-title">
                            Order Summary
                        </div>


                        <div class="table-responsive">


                            <table class="table table-striped table-hover table-md">


                                <tr>

                                    <th width="40">
                                        #
                                    </th>

                                    <th>
                                        Item
                                    </th>

                                    <th class="text-center">
                                        Price
                                    </th>

                                    <th class="text-center">
                                        Quantity
                                    </th>

                                    <th class="text-right">
                                        Total
                                    </th>

                                </tr>



                                @foreach($order->orderItems as $item)


                                <tr>


                                    <td>
                                        {{ $loop->iteration }}
                                    </td>



                                    <td>


                                        {{ $item->product_name }}



                                        @if($item->product_size)

                                            @php
                                                $size = $item->product_size;

                                                if (is_string($size)) {
                                                    $size = json_decode($size, true);
                                                }
                                            @endphp


                                            @if(!empty($size))

                                             <br>

                                             <small>

                                                <strong>Size:</strong>
                                                @if(is_array($size))

                                                    {{ $size['name'] ?? '' }}

                                                    @if(isset($size['price']))
                                                        (+{{ currencyPosition($size['price']) }})
                                                    @endif

                                                @else

                                                    {{ currencyPosition($size) }}

                                                @endif
                                             


                                             </small>
                                            @endif

                                        @endif




                                        @if($item->product_option )

                                            @php
                                                $options = $item->product_option;

                                                if (is_string($options)) {
                                                    $options = json_decode($options, true);
                                                }
                                            @endphp
                                            @if(!empty($options))

                                                <br>

                                                <small>

                                                    <strong>Option:</strong>

                                                    @if(is_array($options))

                                                        @foreach($options as $option)

                                                            @if(is_array($option))

                                                                {{ $option['name'] ?? '' }}

                                                                @if(isset($option['price']))
                                                                    (+{{ currencyPosition($option['price']) }})
                                                                @endif

                                                            @else

                                                                {{ currencyPosition($option) }}

                                                            @endif


                                                            @if(!$loop->last)
                                                                ,
                                                            @endif

                                                        @endforeach

                                                    @else

                                                        {{ $options }}

                                                    @endif

                                                </small>

                                            @endif
                                            

                                        @endif


                                    </td>




                                    <td class="text-center">

                                        {{ $item->unit_price }}

                                    </td>



                                    <td class="text-center">

                                        {{ $item->qty }}

                                    </td>



                                    <td class="text-right">

                                        {{ currencyPosition($item->unit_price * $item->qty) }}

                                    </td>


                                </tr>


                                @endforeach



                            </table>


                        </div>





                        <div class="row mt-4">


                            <div class="col-lg-8">

                                <div class="section-title">
                                    Payment Method
                                </div>


                                <p class="section-lead">

                                    Payment method :
                                    {{ $order->payment_method ?? 'N/A' }}

                                </p>


                            </div>





                            <div class="col-lg-4 text-right">


                                <div class="invoice-detail-item">

                                    <div class="invoice-detail-name">
                                        Subtotal
                                    </div>

                                    <div class="invoice-detail-value">
                                        {{ currencyPosition($order->subtotal) }}
                                    </div>

                                </div>




                                <div class="invoice-detail-item">

                                    <div class="invoice-detail-name">
                                        Discount
                                    </div>

                                    <div class="invoice-detail-value">
                                        {{  currencyPosition($order->discount) }}
                                    </div>

                                </div>





                                <div class="invoice-detail-item">

                                    <div class="invoice-detail-name">
                                        Delivery Charge
                                    </div>

                                    <div class="invoice-detail-value">
                                        {{  currencyPosition($order->delivery_charge) }}
                                    </div>

                                </div>




                                <hr>



                                <div class="invoice-detail-item">


                                    <div class="invoice-detail-name">
                                        Total
                                    </div>


                                    <div class="invoice-detail-value invoice-detail-value-lg">

                                        {{ currencyPosition($order->grand_total) }}

                                    </div>


                                </div>


                            </div>


                        </div>

                       
                           

                       
                    </div>


                </div>


            </div>


             <div class="row mt-4">

                                <div class="col-md-6">
                                    <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="form-group">
                                            <label><strong>Payment Status</strong></label>

                                            <select name="payment_status" class="form-control">
                                                <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="completed" {{ $order->payment_status == 'completed' ? 'selected' : '' }}>Completed</option>
                                                
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label><strong>Order Status</strong></label>

                                            <select name="order_status" class="form-control">
                                                <option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}>
                                                    Pending
                                                </option>

                                                <option value="in_process" {{ $order->order_status == 'in_process' ? 'selected' : '' }}>
                                                    In Process
                                                </option>

                                                <option value="delivered" {{ $order->order_status == 'delivered' ? 'selected' : '' }}>
                                                    Delivered
                                                </option>

                                                <option value="declined" {{ $order->order_status == 'declined' ? 'selected' : '' }}>
                                                    Declined
                                                </option>
                                            </select>
                                        </div>

                                        <button type="submit" class="btn btn-primary">
                                            Update Order
                                        </button>
                                    </form>
                                </div>

                           </div>


            <hr>





            <div class="text-md-right">


               




                <button class="btn btn-warning btn-icon icon-left" id="print_btn">

                    <i class="fas fa-print"></i>

                    Print

                </button>


            </div>


        </div>


    </div>


</section>


@endsection

@push('scripts') 
<script>
$(document).ready(function(){

    $('#print_btn').on('click', function(){

        let printContents = $('.invoice-print').html();

        let printWindow = window.open('', '', 'width=900,height=700');

        printWindow.document.write(`
            <html>
            <head>
                <title>Invoice</title>

                <link rel="stylesheet" href="{{ asset('admin/assets/modules/bootstrap/css/bootstrap.min.css') }}">

                <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">

                <link rel="stylesheet" href="{{ asset('admin/assets/css/components.css') }}">

                <link rel="stylesheet" href="{{ asset('admin/assets/modules/fontawesome/css/all.min.css') }}">

                <style>
                    body {
                        padding: 30px;
                        background: white !important;
                    }

                    .invoice-print {
                        width: 100%;
                    }

                    .table-responsive {
                        overflow: visible !important;
                    }

                    @media print {
                        .no-print {
                            display:none;
                        }
                    }
                </style>

            </head>

            <body>

                <div class="invoice">
                    ${printContents}
                </div>

            </body>

            </html>
        `);

        printWindow.document.close();

        setTimeout(function(){
            printWindow.print();
            printWindow.close();
        }, 500);

    });

});
</script>


@endpush