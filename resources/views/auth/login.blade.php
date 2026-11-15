@extends('frontend.layouts.master')


@section('content')
    <!--=============================
        BREADCRUMB START
    ==============================-->

    <section class="fp__breadcrumb" style="background: url({{asset('frontend/images/counter_bg.jpg')}});">
        <div class="fp__breadcrumb_overlay">
            <div class="container">
                <div class="fp__breadcrumb_text">
                    <h1>Connexion</h1>
                    <ul>
                        <li><a href="{{route('home')}}">Accueil</a></li>
                        <li><a href="#">Connexion</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        BREADCRUMB END
    ==============================-->


    <!--=========================
        SIGNIN START
    ==========================-->
    <section class="fp__signin" style="background: url({{asset('frontend/images/login_bg.jpg')}});">
        <div class="fp__signin_overlay pt_125 xs_pt_95 pb_100 xs_pb_70">
            <div class="container">
                <div class="row wow fadeInUp" data-wow-duration="1s">
                    <div class="col-xxl-5 col-xl-6 col-md-9 col-lg-7 m-auto">
                        <div class="fp__login_area">
                            <h2>Bon retour parmi nous!</h2>
                            <p>Connectez-vous pour continuer</p>
                            <form method="POST" action="{{ route('login') }}"  novalidate>
                                @csrf
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="fp__login_imput">
                                            <label>Email</label>
                                            <input type="email"  name="email" placeholder="E-mail" value="{{old('email')}}"  required>
                                        </div>
                                    </div>
                                    
                                    
                                    
                                    <div class="col-xl-12">
                                        <div class="fp__login_imput">
                                            <label>Mot de password</label>
                                            <input type="password" name="password" placeholder="Votre mot de passe">
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="fp__login_imput fp__login_check_area">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="flexCheckDefault" name="remember">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    Se souvenir de moi
                                                </label>
                                            </div>
                                            <a href="{{route('password.request')}}">Mot de passe oublié ?</a>
                                        </div>
                                    </div>
                                    
                                    
                                    
                                    <div class="col-xl-12">
                                        <div class="fp__login_imput">
                                            <button type="submit" class="common_btn">Connexion</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <p class="or"><span>Ou</span></p>
                            
                            <p class="create_account">N'avez vous pas un compte ? <a href="{{route('register')}}">Créer un compte</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=========================
        SIGNIN END
    ==========================-->
@endsection