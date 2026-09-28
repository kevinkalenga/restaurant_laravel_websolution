@extends('frontend.layouts.master')

@section('content') 



   
    <section class="fp__breadcrumb" style="background: url({{asset('frontend/images/counter_bg.jpg')}});">
        <div class="fp__breadcrumb_overlay">
            <div class="container">
                <div class="fp__breadcrumb_text">
                    <h1>About Us</h1>
                    <ul>
                        <li><a href="{{route('home')}}">home</a></li>
                        <li><a href="javascript:;">about us</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
 
    <section class="fp__about_us mt_120 xs_mt_90">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-5 wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__about_us_img">
                        <img src="{{asset($about->image)}}" alt="about us" class="img-fluid w-100">
                    </div>
                </div>
                <div class="col-xl-6 col-lg-7 wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__section_heading mb_40">
                        <h4>{!!$about->title !!}</h4>
                        <h2>{!!$about->main_title !!}</h2>
                        <span>
                            <img src="images/heading_shapes.png" alt="shapes" class="img-fluid w-100">
                        </span>
                    </div>
                    <div class="fp__about_us_text">
                         {!! ($about->description) !!}
                        
                    </div>
                </div>
            </div>
        </div>
    </section>

       <!--=============================
        WHY CHOOSE START
    ==============================-->
         @include('frontend.home.components.why_choose');
    <!--=============================
        WHY CHOOSE END
    ==============================-->

    <section class="fp__about_video mt_100 xs_mt_70">
        <div class="container wow fadeInUp" data-wow-duration="1s">
            <div class="fp__about_video_bg" style="background: url({{getYtThumbnail($about->video_link, 'high')}});">
                <div class="fp__about_video_overlay">
                    <div class="row">
                        <div class="col-12">
                            <div class="fp__about_video_text">
                                <p>Watch Videos</p>
                                <a class="play_btn venobox" data-autoplay="true" data-vbtype="video"
                                    href="{{$about->video_link}}">
                                    <i class=" fas fa-play"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

      <!--=============================
        TEAM START
    ==============================-->
        @include('frontend.home.components.team');
    <!--=============================
        TEAM END
    ==============================-->

      <!--=============================
        COUNTER START
    ==============================-->
        @include('frontend.home.components.counter');
    <!--=============================
        COUNTER END
    ==============================-->

    <!--=============================
       TESTIMONIAL  START
    ==============================-->
        @include('frontend.home.components.testimonials');
    <!--=============================
        TESTIMONIAL END
    ==============================-->
  

 <style>

   .fp__about_us_text p {
    margin: 15px 0px;
}

.fp__about_us_text ul,
.fp__about_us_text ol {
    display: flex;
    flex-wrap: wrap;
    padding: 0;
    margin: 0;
    list-style: none;
}

.fp__about_us_text ul li,
.fp__about_us_text ol li {
    text-transform: capitalize;
    font-size: 16px;
    color: var(--colorBlack);
    width: 50%;
    padding-left: 30px;
    position: relative;
    margin-top: 15px;
    list-style: none;
}

.fp__about_us_text ul li::after,
.fp__about_us_text ol li::after {
    position: absolute;
    content: "\f00c";
    color: var(--colorWhite);
    font-family: "Font Awesome 5 Free";
    font-weight: 600;
    top: 2px;
    left: 0;
    font-size: 10px;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    text-align: center;
    line-height: 20px;
    background: var(--colorPrimary);
}

 </style>
@endsection 