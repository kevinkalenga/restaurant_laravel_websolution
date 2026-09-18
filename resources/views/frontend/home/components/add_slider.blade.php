  <section class="fp__add_slider mt_100 xs_mt_70 pt_100 xs_pt_70 pb_100 xs_pb_70">
        <div class="container">
            <div class="row add_slider wow fadeInUp" data-wow-duration="1s">
                @foreach($bannerSliders as $item)
                    <div class="col-xl-4">
                        <a href="{{$item->url}}" class="fp__add_slider_single" style="background: url('{{asset($item->banner)}}');">
                            <div class="text">
                                <h3>{{$item->title}}</h3>
                                <p>{!! $item->sub_title !!}</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>