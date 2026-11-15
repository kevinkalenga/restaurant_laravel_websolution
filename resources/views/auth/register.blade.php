
@extends('frontend.layouts.master')

@section('content') 


    <!--=============================
        BREADCRUMB START
    ==============================-->
    <section class="fp__breadcrumb" style="background: url({{asset('frontend/images/counter_bg.jpg')}});">
        <div class="fp__breadcrumb_overlay">
            <div class="container">
                <div class="fp__breadcrumb_text">
                    <h1>Inscription</h1>
                    <ul>
                        <li><a href="{{route('home')}}">Accueil</a></li>
                        <li><a href="#">Inscription</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        BREADCRUMB END
    ==============================-->


    <!--=========================
        SIGN UP START
    ==========================-->
    <section class="fp__signup" style="background: url({{asset('frontend/images/login_bg.jpg')}});">
        <div class="fp__signup_overlay pt_125 xs_pt_95 pb_100 xs_pb_70">
            <div class=" container">
                <div class="row wow fadeInUp" data-wow-duration="1s">
                    <div class="col-xxl-5 col-xl-6 col-md-9 col-lg-7 m-auto">
                        <div class="fp__login_area">
                            <h2>Bon retour parmi nous!</h2>
                            <p>Inscrivez-vous pour continuer</p>
                             <form method="POST" action="{{ route('register') }}"  novalidate>
                                @csrf
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="fp__login_imput">
                                            <label>Nom</label>
                                            <input type="text" placeholder="Nom" name="name" value="{{old('name')}}" required>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="fp__login_imput">
                                            <label>Email</label>
                                            <input type="email" placeholder="E-mail" name="email" value="{{old('email')}}">
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="col-xl-12">
                                        <div class="fp__login_imput">
                                            <label>GSM</label>
                                            <input
                                                type="tel"
                                                placeholder="GSM"
                                                name="phone"
                                                value="{{ old('phone') }}"
                                                required
                                            >
                                           
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="col-xl-12">
                                        <div class="fp__login_imput">
                                            <label>Mot de passe</label>
                                            <input type="password" placeholder="Votre mot de passe"  name="password">
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="fp__login_imput">
                                            <label>Confirmation de mot de passe</label>
                                            <input type="password" placeholder="Confirmation de mot de passe" name="password_confirmation">
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="fp__login_imput">
                                            <button type="submit" class="common_btn">S'inscrire</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <p class="or"><span>Ou</span></p>
                           
                            <p class="create_account">Avez-vous deja un compte ? <a href="{{route('login')}}">Connectez-vous</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=========================
        SIGN UP END
    ==========================-->




@endsection