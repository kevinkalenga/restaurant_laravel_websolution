 <div class="tab-pane fade show active" id="paypal-setting" role="tabpanel" aria-labelledby="home-tab4">
                            <form action="{{route('admin.paypal-setting.update')}}" method="POST" enctype="multipart/form-data">
                              @csrf 
                              @method('PUT')
                              <div class="card-body border">
                                 
                                 <div class="form-group">
                                    <label for="">Paypal Status</label>
                                    <select name="paypal_status" id="" class="select2 form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                  
                                    </select>
                                 </div>
                                 <div class="form-group">
                                    <label for="">Paypal Account Mode</label>
                                    <select name="paypal_account_mode" id="" class="select2 form-control">
                                        <option value="sandbox">Sandbox</option>
                                        <option value="live">Live</option>
                                  
                                    </select>
                                 </div>
                                 <div class="form-group">
                                    <label for="">Paypal Country Name</label>
                                    <select name="paypal_country" id="" class="select2 form-control">
                                        <option value="">Select</option>
                                        @foreach(config('country_list') as $key => $country)
                                             <option value="{{$key}}">{{$country}}</option>
                                        @endforeach
                                  
                                    </select>
                                 </div>
                                 
                                 
                                 <div class="form-group">
                                    <label for="">Paypal Currency Name</label>
                                    <select name="paypal_currency" id="" class="select2 form-control">
                                        <option value="">Select</option>
                                        @foreach(config('currency.currency_list') as $currency_country) 
                                            
                                             <option @selected(config('settings.site_default_currency') === $currency_country) value="{{$currency_country}}">{{$currency_country}}</option>

                                        @endforeach
                                    </select>
                                 </div>
                                 
                                 
                                 
                                 <div class="form-group">
                                    <label for="">Currency Rate (Per {{config('settings.site_default_currency')}})</label>
                                    <input type="text" class="form-control" name="paypal_rate" value="">
                                 </div>
                                 
                                 <div class="form-group">
                                    <label for="">Paypal Client Id</label>
                                    <input type="text" class="form-control" name="paypal_api_key" value="">
                                 </div>
                                 
                              
                                 <div class="form-group">
                                    <label for="">Paypal Secret Key</label>
                                    <input type="text" class="form-control" name="paypal_secret_key" value="">
                                 </div>
                                 <div class="form-group">
                                    <label for="">Paypal Logo</label>
                                    <div di="image-preview" class="image-preview">
                                       <label for="image-upload" id="image-label">Choose File</label>
                                      <input type="file" id="image-upload" name="paypal_logo">
                                    </div>
                                 </div>
                             
                                
                                  <button type="submit" class="btn btn-primary">Save</button>
                              </div>
                            </form>
                          </div>

 @push('scripts') 
  <script>
     $(document).ready(function(){
        $('.image-preview').css({
          'background-image': 'url({{asset(auth()->user()->avatar)}})',
          'background-size': 'cover',
          'background-position': 'center center'
        })
     })
  </script>

@endpush