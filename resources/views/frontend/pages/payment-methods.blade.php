@extends('frontend.layouts.master')

@section('content')

<section class="fp__payment_page mt_100 xs_mt_70 mb_100 xs_mb_70">
    <div class="container" style="padding-top: 120px;">

        <div class="text-center mb_50">
            <h2>Payment Methods</h2>
            <p>We accept the following payment methods:</p>
        </div>

        <div class="row justify-content-center">

            @if(config('gatewaySettings.paypal_status'))
                <div class="col-lg-3 col-6 col-sm-4 col-md-3">
                    <div class="fp__single_payment payment-card">
                        <img
                            src="{{ asset(config('gatewaySettings.paypal_logo')) }}"
                            alt="PayPal"
                            class="img-fluid w-100"
                        >
                    </div>
                </div>
            @endif

            @if(config('gatewaySettings.stripe_status'))
                <div class="col-lg-3 col-6 col-sm-4 col-md-3">
                    <div class="fp__single_payment payment-card">
                        <img
                            src="{{ asset(config('gatewaySettings.stripe_logo')) }}"
                            alt="Stripe"
                            class="img-fluid w-100"
                        >
                    </div>
                </div>
            @endif

        </div>

    </div>
</section>

@endsection