@extends('frontend.layouts.master')


@section('content') 



    <!--=============================
        BREADCRUMB START
    ==============================-->
    <section class="fp__breadcrumb" style="background: url({{asset(config('settings.breadcrumb'))}});">
        <div class="fp__breadcrumb_overlay">
            <div class="container">
                <div class="fp__breadcrumb_text">
                    <h1>Commande</h1>
                    <ul>
                        <!-- <li><a href="{{url('/')}}">home</a></li>
                        <li><a href="javascript:;">payment</a></li> -->
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        BREADCRUMB END
    ==============================-->


    <!--============================
        PAYMENT PAGE START
    ==============================-->
    <section class="fp__payment_page mt_100 xs_mt_70 mb_100 xs_mb_70">
        <div class="container">
            
            <div class="row">
               
                <div class="text-center">
                    <div class="mb-4">
                        <i class="fas fa-times-circle order-cancel-style"></i>
                    </div>
                   <h4>Échec de la transaction !</h4>
                   <p><b class="mx-5">{{session()->has('errors') ? session('errors')->first('error') : '' }}</b></p>
                   <a class="common_btn mt-3" href="{{route('make.payment')}}">Accéder à la page de paiement</a>
                </div>
                
            </div>
        </div>
    </section>

   
    <!--============================
        PAYMENT PAGE END
    ==============================-->


@endsection 
