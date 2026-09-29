<div class="tab-pane fade show active" id="mail-setting" role="tabpanel" aria-labelledby="home-tab4">
                            <form action="{{route('admin.pusher-setting.update')}}" method="POST">
                              @csrf 
                              @method('PUT')
                              < class="card-body border">
                                 <div class="row">
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="">Mail Driver</label>
                                          <input type="text" class="form-control" name="mail_driver">
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="">Mail Host</label>
                                          <input type="text" class="form-control" name="mail_host">
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="">Mail Port</label>
                                          <input type="text" class="form-control" name="mail_port">
                                       </div>
                                    </div>
                                 </div>
                                 
                                 <div class="row">
                                      <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="">Mail Username</label>
                                             <input type="text" class="form-control" name="mail_username">
                                          </div>
                                      </div>
                                      <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="">Mail Password</label>
                                             <input type="text" class="form-control" name="mail_password">
                                          </div>
                                      </div>
                                      <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="">Mail Encryption</label>
                                             <input type="text" class="form-control" name="mail_encryption">
                                          </div>
                                      </div>
                                 </div>
                                
                                 
                                 
                               
                                          <div class="form-group">
                                             <label for="">Mail Encryption</label>
                                             <input type="text" class="form-control" name="mail_encryption">
                                          </div>
                                 
                                 
                                          <div class="form-group">
                                             <label for="">Mail From Address</label>
                                             <input type="text" class="form-control" name="mail_from_address">
                                          </div>
                                          <div class="form-group">
                                             <label for="">Mail Receive Address</label>
                                             <input type="text" class="form-control" name="mail_receive_address">
                                          </div>
                                 
                                  
                                
                                  <button type="submit" class="btn btn-primary">Save</button>
                              </div>
                            </form>
                          </div>