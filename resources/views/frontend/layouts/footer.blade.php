    
    @php 
     
        $footerInfo = \App\Models\FooterInfo::first();
        $footerMenuOne = LaravelMenu::getByName('footer_menu_one');
        $footerMenuTwo = LaravelMenu::getByName('footer_menu_two');

         $openingHours = \App\Models\OpeningHour::all();

        $days = [
            'monday' => 'Lundi',
            'tuesday' => 'Mardi',
            'wednesday' => 'Mercredi',
            'thursday' => 'Jeudi',
            'friday' => 'Vendredi',
            'saturday' => 'Samedi',
            'sunday' => 'Dimanche',
        ];

    @endphp
    
    <footer>
        <div class="footer_overlay pt_100 xs_pt_70 pb_100 xs_pb_70">
            <div class="container wow fadeInUp" data-wow-duration="1s">
                <div class="row justify-content-between">
                    <div class="col-lg-4 col-sm-8 col-md-6">
                        <div class="fp__footer_content">
                            <a class="footer_logo" href="{{url('/')}}">
                                <img src="{{asset(config('settings.footer_logo'))}}" alt="restauran" class="img-fluid w-100">
                                <!-- <img src="{{asset('frontend/images/footer_logo.png')}}" alt="FoodPark" class="img-fluid w-100"> -->
                                
                            </a>
                            @if($footerInfo->short_info)
                                 <span>{!! $footerInfo->short_info !!}</span>
                            @endif
                            @if($footerInfo->address)
                               <p class="info"><i class="far fa-map-marker-alt"></i>{!! $footerInfo->address !!}</p>
                            @endif
                            @if($footerInfo->phone)
                              <a class="info" href="callto:{{$footerInfo->phone}}"><i class="fas fa-phone-alt"></i>
                                {{$footerInfo->phone}}</a>
                            @endif
                             @if($footerInfo->email)
                                <a class="info" href="mailto:{{$footerInfo->email}}"><i class="fas fa-envelope"></i>
                                    {{$footerInfo->email}}
                                </a>
                             @endif
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-4 col-md-6">
                        <div class="fp__footer_content">
                            <h3>Short Link</h3>
                            <ul>
                                @foreach($footerMenuOne as $menuItem)
                                  <li><a href="{{$menuItem['link']}}">{{$menuItem['label']}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-4 col-md-6 order-sm-4 order-lg-3">
                        <div class="fp__footer_content">
                            <h3>Opening Hours</h3>
                            <ul>
                                    @foreach($openingHours as $openingHour)
                                        <li>
                                            {{ $days[$openingHour->day] ?? $openingHour->day }} :

                                            @if($openingHour->is_closed)
                                                Closed
                                            @else
                                                {{ substr($openingHour->open_time, 0, 5) }}
                                                -
                                                {{ substr($openingHour->close_time, 0, 5) }}
                                            @endif
                                        </li>
                                    @endforeach
                            </ul>
                            
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-8 col-md-6 order-lg-4">
                        <div class="fp__footer_content">
                            <h3>subscribe</h3>
                            <form class="subscribe_form">
                                @csrf
                                <input type="text" placeholder="Subscribe" name="email">
                                <button type="submit" class="subscribe_btn">Subscribe</button>
                            </form>
                             @php 
                               $socialLinks = \App\Models\SocialLink::where('status', 1)->get();

                            @endphp
                            <div class="fp__footer_social_link">
                                <h5>follow us:</h5>
                                <ul class="d-flex flex-wrap">
                                    @foreach($socialLinks as $socialLink)
                                       <li><a href="{{$socialLink->link}}"><i class="{{$socialLink->icon}}"></i></a> </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="fp__footer_bottom d-flex flex-wrap">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="fp__footer_bottom_text d-flex flex-wrap justify-content-between">
                             @if($footerInfo->copyright)
                                <p>{{$footerInfo->copyright}}</p>
                             @endif
                            <ul class="d-flex flex-wrap">
                                @foreach($footerMenuTwo as $menuItem)  
                                  <li><a href="{{$menuItem['link']}}">{{$menuItem['label']}}</a></li>
                                @endforeach
                                <li>
                                   <a href="{{ url('/page/legal-notice') }}">Legal Notice</a>
                                </li>
                                
                                <li>
                                    <a href="{{ url('/page/conditions-generales-de-vente') }}">
                                        Conditions générales de vente
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    @push('scripts')

        <script>

         $(document).ready(function () {

            $('.subscribe_form').on('submit', function (e) {

                e.preventDefault();

                let form = $(this);
                let button = form.find('.subscribe_btn');
                let formData = form.serialize();

                // Envoi
                $.ajax({

                    method: 'POST',
                    url: "{{ route('subscribe-newsletter') }}",
                    data: formData,
                    dataType: 'json',

                    // Chargement
                    beforeSend: function () {

                        button
                            .prop('disabled', true)
                            .html(`
                                <span class="spinner-border spinner-border-sm"
                                    role="status"
                                    aria-hidden="true"></span>
                                <span class="ms-2">Sending...</span>
                            `);
                    },

                    // Succès
                    success: function (response) {

                        iziToast.success({
                            title: 'Success',
                            message: response.message ||
                                "You've been subscribed successfully!",
                            position: 'topRight'
                        });

                        form[0].reset();
                    },

                    // Erreur
                    error: function (xhr) {

                        if (
                            xhr.status === 422 &&
                            xhr.responseJSON &&
                            xhr.responseJSON.errors
                        ) {

                            $.each(
                                xhr.responseJSON.errors,
                                function (field, messages) {

                                    $.each(messages, function (index, error) {

                                        iziToast.error({
                                            title: 'Error',
                                            message: error,
                                            position: 'topRight',
                                            timeout: 5000
                                        });

                                    });

                                }
                            );

                            return;
                        }

                        iziToast.error({
                            title: 'Error',
                            message: xhr.responseJSON?.message ||
                                'Something went wrong. Please try again.',
                            position: 'topRight',
                            timeout: 5000
                        });
                    },

                    // Fin
                    complete: function () {

                        button
                            .prop('disabled', false)
                            .html('Subscribe');
                    }

                });

            });

          });


        </script>


    @endpush