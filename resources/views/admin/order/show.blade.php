@extends('admin.layouts.master')

@section('content')

<section class="section">

    <div class="section-header">
        <h1>Invoice</h1>

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

                                    {{ ucfirst($order->order_status) }}

                                    <br><br>

                                    <strong>Payment Status:</strong>
                                    <br>

                                    {{ ucfirst($order->payment_status) }}

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

                                            <br>

                                            <small>

                                                <strong>Size:</strong>

                                                @foreach($item->product_size as $key => $value)

                                                    @if(is_array($value))

                                                        {{ ucfirst($key) }}:
                                                        {{ implode(', ', $value) }}

                                                    @else

                                                        {{ ucfirst($key) }}:
                                                        {{ $value }}

                                                    @endif

                                                @endforeach


                                            </small>

                                        @endif




                                        @if($item->product_option)

                                            <br>

                                            <small>

                                                <strong>Option:</strong>

                                                @foreach($item->product_option as $key => $value)

                                                    @if(is_array($value))

                                                        {{ ucfirst($key) }}:
                                                        {{ implode(', ', $value) }}

                                                    @else

                                                        {{ ucfirst($key) }}:
                                                        {{ $value }}

                                                    @endif

                                                @endforeach


                                            </small>

                                        @endif


                                    </td>




                                    <td class="text-center">

                                        {{ $item->unit_price }}

                                    </td>



                                    <td class="text-center">

                                        {{ $item->qty }}

                                    </td>



                                    <td class="text-right">

                                        {{ $item->unit_price * $item->qty }}

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
                                        {{ $order->subtotal }}
                                    </div>

                                </div>




                                <div class="invoice-detail-item">

                                    <div class="invoice-detail-name">
                                        Discount
                                    </div>

                                    <div class="invoice-detail-value">
                                        {{ $order->discount }}
                                    </div>

                                </div>





                                <div class="invoice-detail-item">

                                    <div class="invoice-detail-name">
                                        Delivery Charge
                                    </div>

                                    <div class="invoice-detail-value">
                                        {{ $order->delivery_charge }}
                                    </div>

                                </div>




                                <hr>



                                <div class="invoice-detail-item">


                                    <div class="invoice-detail-name">
                                        Total
                                    </div>


                                    <div class="invoice-detail-value invoice-detail-value-lg">

                                        {{ $order->grand_total }}

                                    </div>


                                </div>


                            </div>


                        </div>


                    </div>


                </div>


            </div>





            <hr>





            <div class="text-md-right">


               




                <button class="btn btn-warning btn-icon icon-left">

                    <i class="fas fa-print"></i>

                    Print

                </button>


            </div>


        </div>


    </div>


</section>


@endsection