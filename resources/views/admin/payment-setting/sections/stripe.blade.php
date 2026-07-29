 <div class="tab-pane fade" id="stripe-setting" role="tabpanel" aria-labelledby="home-tab4">
                            <form action="{{route('admin.stripe-setting.update')}}" method="POST" enctype="multipart/form-data">
                              @csrf 
                              @method('PUT')
                              <div class="card-body border">
                                 
                                 <div class="form-group">
                                    <label for="">Stripe Status</label>
                                    <select name="stripe_status" id="" class="select2 form-control">
                                        <option @selected(@$paymentGateway["stripe_status"] === 1) value="1">Active</option>
                                        <option @selected(@$paymentGateway["stripe_status"] === 0) value="0">Inactive</option>
                                  
                                    </select>
                                 </div>
                                 {{-- <div class="form-group">
                                    <label for="">Stripe Account Mode</label>
                                    <select name="paypal_account_mode" id="" class="select2 form-control">
                                        <option @selected(@$paymentGateway["paypal_account_mode"] === "sandbox") value="sandbox">Sandbox</option>
                                        <option @selected(@$paymentGateway["paypal_account_mode"] === "live") value="live">Live</option>
                                  
                                    </select>
                                 </div> --}}
                                 <div class="form-group">
                                    <label for="">Stripe Country Name</label>
                                    <select name="stripe_country" id="" class="select2 form-control">
                                        <option value="">Select</option>
                                        @foreach(config('country_list') as $key => $country)
                                             <option @selected(@$paymentGateway["stripe_country"] === $key) value="{{$key}}">{{$country}}</option>
                                        @endforeach
                                  
                                    </select>
                                 </div>
                                 
                                 
                                 <div class="form-group">
                                    <label for="">Stripe Currency Name</label>
                                    <select name="stripe_currency" id="" class="select2 form-control">
                                        <option value="">Select</option>
                                        @foreach(config('currency.currency_list') as $currency) 
                                            
                                             <option @selected(@$paymentGateway["stripe_currency"] === $currency) value="{{@$currency}}">{{$currency}}</option>

                                        @endforeach
                                    </select>
                                 </div>
                                 
                                 
                                 
                                 <div class="form-group">
                                    <label for="">Currency Rate (Per {{config('settings.site_default_currency')}})</label>
                                    <input type="text" class="form-control" name="stripe_rate" value="{{@$paymentGateway['stripe_rate']}}">
                                 </div>
                                 
                                 <div class="form-group">
                                    <label for="">Stripe Key</label>
                                    <input type="text" class="form-control" name="stripe_api_key" value="{{@$paymentGateway['stripe_api_key']}}">
                                 </div>
                                 
                              
                                 <div class="form-group">
                                    <label for="">Stripe Secret Key</label>
                                    <input type="text" class="form-control" name="stripe_secret_key" value="{{@$paymentGateway['stripe_secret_key']}}">
                                 </div>
                                 <div class="form-group">
                                    <label for="">Stripe Logo</label>
                                    <div id="image-preview-2" class="image-preview stripe-preview">
                                       <label for="image-upload-2" id="image-label-2">Choose File</label>
                                      <input type="file" id="image-upload-2" name="stripe_logo">
                                    </div>
                                 </div>
                             
                                
                                  <button type="submit" class="btn btn-primary">Save</button>
                              </div>
                            </form>
                          </div>

 @push('scripts') 
  <script>
     $(document).ready(function(){
        $('.stripe-preview').css({
          'background-image': 'url("{{ asset(@$paymentGateway["stripe_logo"]) }}")',
          'background-size': 'cover',
          'background-position': 'center center'
        })

         $.uploadPreview({
            input_field: "#image-upload-2",   // Default: .image-upload
            preview_box: "#image-preview-2",  // Default: .image-preview
            label_field: "#image-label-2",    // Default: .image-label
            label_default: "Choose File",   // Default: Choose File
            label_selected: "Change File",  // Default: Change File
            no_label: false,                // Default: false
            success_callback: null          // Default: null
        });
       
     })
  </script>

@endpush
