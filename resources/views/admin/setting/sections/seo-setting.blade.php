<div class="tab-pane fade" id="seo-setting" role="tabpanel" aria-labelledby="seo-tab">
                            <form action="{{route('admin.seo-setting.update')}}" method="POST">
                              @csrf 
                              @method('PUT')
                              <div class="card-body border">
                                 <div class="form-group">
                                    <label for="">Seo Title</label>
                                    <input type="text" class="form-control" name="seo_title" value="">
                                 </div>
                                 <div class="form-group">
                                    <label for="">Seo Description</label>
                                    <textarea name="seo_description" class="form-control"></textarea>

                                 </div>
                                 <div class="form-group">
                                    <label>Seo Keyword</label>
                                    <input type="text" class="form-control inputtags" name="seo_keyword" value="">
                                    
                                 </div>
                               
                                  <button type="submit" class="btn btn-primary">Save</button>
                              </div>
                            </form>
                          </div>
 @push('scripts')
<script>
    $(".inputtags").tagsinput('items');
</script>
@endpush 