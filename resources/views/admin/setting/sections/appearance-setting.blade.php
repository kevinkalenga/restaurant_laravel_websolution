<div class="tab-pane fade" id="appearance-setting" role="tabpanel" aria-labelledby="appearance-tab">
                            <form action="{{route('admin.appearance-setting.update')}}" method="POST">
                              @csrf 
                              @method('PUT')
                              <div class="card-body border">
                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Simple</label>
                                        <input type="text" class="form-control colorpickerinput" name="site_color" value="{{config('settings.site_color')}}">
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
