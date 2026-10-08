<div class="tab-pane fade show active" id="general-setting" role="tabpanel" aria-labelledby="general-tab">
                            <form action="{{route('admin.general-setting.update')}}" method="POST">
                              @csrf 
                              @method('PUT')
                              <div class="card-body border">
                                 <div class="form-group">
                                    <label for="">Site Name</label>
                                    <input type="text" class="form-control" name="site_name" value="{{config('settings.site_name')}}">
                                 </div>
                                 <div class="row">
                                     <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Site Email</label>
                                            <input type="text" class="form-control" name="site_email" value="{{config('settings.site_email')}}">
                                        </div>
                                     </div>
                                     <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Site Phone</label>
                                            <input type="text" class="form-control" name="site_phone" value="{{config('settings.site_phone')}}">
                                        </div>
                                     </div>
                                 </div>
                                 
                                 <div class="form-group">
                                    <label for="">Default Currency</label>
                                    {{--inside the class => select2--}}
                                    <select name="site_default_currency" id="" class="form-control">
                                        <option value="">Select</option>
                                        @foreach(config('currency.currency_list') as $currency_country) 
                                            
                                             <option @selected(config('settings.site_default_currency') === $currency_country) value="{{$currency_country}}">{{$currency_country}}</option>

                                        @endforeach
                                    </select>
                                 </div>
                                  <div class="row">
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="">Currency Icon</label>
                                        {{--inside the class => select2--}}
                                        <input type="text" name="site_currency_icon" class="form-control" value="{{config('settings.site_currency_icon')}}">
                                      </div>
                                    
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="">Currency Icon Position</label>
                                         {{--inside the class => select2--}}
                                        <select name="site_currency_icon_position" id="" class="form-control">
                                           <option @selected(config('settings.site_currency_icon_position') === 'right') value="right">Right</option>
                                           <option @selected(config('settings.site_currency_icon_position') === 'left') value="left">Left</option>
                                        </select>
                                      </div>
                                    
                                    </div>
                                   
                                  </div>
                                  <button type="submit" class="btn btn-primary">Save</button>
                              </div>
                            </form>
                          </div>