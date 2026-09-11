


<div class="tab-pane fade" id="v-pills-settings" role="tabpanel"
    aria-labelledby="v-pills-settings-tab">
    <div class="fp_dashboard_body fp__change_password">
        <div class="fp__message">
            <h3>Message</h3>
            <div class="fp__chat_area">
                <div class="fp__chat_body">
                   
                    {{--<div class="fp__chating">
                        <div class="fp__chating_img">
                            <img src="{{asset('frontend/images/service_provider.png')}}" alt="person"
                                class="img-fluid w-100">
                        </div>
                        <div class="fp__chating_text">
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.
                            </p>
                            <span>15 Jun, 2023, 05:26 AM</span>
                        </div>
                    </div>--}}
                    {{--<div class="fp__chating tf_chat_right">
                        <div class="fp__chating_img">
                            <img src="{{asset('admin/img/client_img_1.png')}}" alt="person"
                                class="img-fluid w-100">
                        </div>
                        <div class="fp__chating_text">
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.
                            </p>
                            <span>15 Jun, 2023, 05:26 AM</span>
                        </div>
                    </div>--}}
                </div>
                <form class="fp__single_chat_bottom chat_input" action="chat.send-message" method="POST" >
                    @csrf
                    <label for="select_file"><i class="far fa-file-medical"
                            aria-hidden="true"></i></label>
                    <input id="select_file" type="file" hidden="">
                    <input type="text" placeholder="Type a message..." name="message" class="fp_send_message">
                    <input type="hidden" name="receiver_id" value="1">
                    <button class="fp__massage_btn" type="submit"><i class="fas fa-paper-plane"
                            aria-hidden="true"></i></button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')

 <script>
    $(document).ready(function(){
      var userId = "{{auth()->user()->id}}"
      $('.fp_chat_message').on('click', function(){

      
        let senderId = 1;
          
            $.ajax({
                method: 'GET',
                url: '{{route("chat.get-conversation", ":senderId")}}'.replace(":senderId", senderId),
                beforeSend: function() {

                },
                success: function(response) {
                    console.log(response)
                    $('.fp__chat_body').empty();
                
                    $.each(response, function(index, message){

                        let avatar = "{{asset(':avatar')}}".replace(':avatar', message.sender.avatar)
                        let html =
                            `
                               <div class="fp__chating ${message.sender_id == userId ? 'tf_chat_right' : ''}">
                                    <div class="fp__chating_img">
                                        <img src="${avatar}" alt="person"
                                            class="img-fluid w-100" style="border-radius:50%;">
                                    </div>
                                    <div class="fp__chating_text">
                                        <p>
                                           ${message.message}
                                        </p>
                                        <span>sending...</span>
                                    </div>
                                </div> 
                               
                            `
                            $('.fp__chat_body').append(html)
                    })

                    scrollToBottom()
                          
                },
                error: function(xhr, status, error) {

                }
        })
    
    
      })
    
      $('.chat_input').on('submit', function(e){
        e.preventDefault();
        let formData = $(this).serialize();
        $.ajax({
            method: 'POST',
            url: "{{route('chat.send-message')}}",
            data: formData,
            beforeSend: function(){
             let message = $('.fp_send_message').val();
             let html =   `
                   <div class="fp__chating tf_chat_right">
                        <div class="fp__chating_img">
                            <img src="{{ asset(auth()->user()->avatar ?? 'uploads/avatar.png') }}" alt="person"
                                class="img-fluid w-100"style="border-radius:50%;">
                        </div>
                        <div class="fp__chating_text">
                            <p>
                              ${message}
                            </p>
                            <span>sending...</span>
                        </div>
                    </div>
                `
                $('.fp__chat_body').append(html)
                $('.fp_send_message').val("")
            },
            success: function(response) {
                //    iziToast.success({
                //         title: 'Success',
                //         message: response.message,
                //         position: 'topRight'
                //     });
            },
            error: function(xhr, status, error){
               
                iziToast.error({
                        title: 'Error',
                        message: xhr.responseJSON.message,
                        position: 'topRight'
                });
            }
        })
      })
    })
 </script>


@endpush