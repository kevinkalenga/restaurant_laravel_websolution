<div class="tab-pane fade show" id="appearance-setting" role="tabpanel" aria-labelledby="home-tab4">
                            <form action="{{route('admin.logo-setting.update')}}" method="POST" enctype="multipart/form-data">
                              @csrf 
                              @method('PUT')
                              <div class="card-body border">
                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Simple</label>
                                        <input type="text" class="form-control colorpickerinput">
                                    </div>
                                  </div>
                                 
                                </div>
                                  <button type="submit" class="btn btn-primary">Save</button>
                              </div>
                            </form>
                          </div>



@push('scripts')
<script>
    
    $(".colorpickerinput").colorpicker({
      format: 'hex',
      component: '.input-group-append',
    });
</script>
@endpush
