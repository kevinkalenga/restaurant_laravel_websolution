<div class="tab-pane fade" id="mail-setting" role="tabpanel" aria-labelledby="mail-tab">
                            <form action="{{route('admin.mail-setting.update')}}" method="POST">
                              @csrf 
                              @method('PUT')
                              <div class="card-body border">
                                 <div class="row">
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="">Mail Driver</label>
                                          <input type="text" class="form-control" name="mail_driver" value="{{config('settings.mail_driver')}}">
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="">Mail Host</label>
                                          <input type="text" class="form-control" name="mail_host" value="{{config('settings.mail_host')}}">
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="">Mail Port</label>
                                          <input type="text" class="form-control" name="mail_port" value="{{config('settings.mail_port')}}">
                                       </div>
                                    </div>
                                 </div>
                                 
                                 <div class="row">
                                      <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="">Mail Username</label>
                                             <input type="text" class="form-control" name="mail_username" value="{{config('settings.mail_username')}}">
                                          </div>
                                      </div>
                                      <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="">Mail Password</label>
                                             <input type="text" class="form-control" name="mail_password" value="{{config('settings.mail_password')}}">
                                          </div>
                                      </div>
                                      <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="">Mail Encryption</label>
                                             <input type="text" class="form-control" name="mail_encryption" value="{{config('settings.mail_encryption')}}">
                                          </div>
                                      </div>
                                 </div>
                                
                                 
                                 
                               
                                          
                                 
                                 
                                          <div class="form-group">
                                             <label for="">Mail From Address</label>
                                             <input type="text" class="form-control" name="mail_from_address" value="{{config('settings.mail_from_address')}}">
                                          </div>
                                          <div class="form-group">
                                             <label for="">Mail Receive Address</label>
                                             <input type="text" class="form-control" name="mail_receive_address" value="{{config('settings.mail_receive_address')}}">
                                          </div>
                                 
                                  
                                
                                  <button type="submit" class="btn btn-primary">Save</button>
</div>
                              </div>
                            </form>
                          </div>