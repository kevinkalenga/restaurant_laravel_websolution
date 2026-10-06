<div class="tab-pane fade show" id="logo-setting" role="tabpanel" aria-labelledby="home-tab4">
                            <form action="{{route('admin.general-setting.update')}}" method="POST">
                              @csrf 
                              @method('PUT')
                              <div class="card-body border">
                                <div class="row">
                                  <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="image-upload">Logo</label>
                                        <div id="image-preview" class="image-preview" 
                                          style="border: 2px dashed #ccc; width: 200px; height: 200px; display: block; overflow: hidden;">
                                          <label for="image-upload" id="image-label" style="cursor:pointer; display:block; text-align:center; line-height:200px;">
                                              Choose File
                                          </label>
                                          <input type="file" name="logo" id="image-upload" class="form-control" style="display:none;">
                                        </div>
                                      
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="image-upload">Footer Logo</label>
                                        <div id="image-preview-2" class="image-preview" 
                                          style="border: 2px dashed #ccc; width: 200px; height: 200px; display: block; overflow: hidden;">
                                          <label for="image-upload-2" id="image-label-2" style="cursor:pointer; display:block; text-align:center; line-height:200px;">
                                              Choose File
                                          </label>
                                          <input type="file" name="footer_logo" id="image-upload-2" class="form-control" style="display:none;">
                                        </div>
                                      
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="image-upload">Favicon</label>
                                        <div id="image-preview-3" class="image-preview" 
                                          style="border: 2px dashed #ccc; width: 200px; height: 200px; display: block; overflow: hidden;">
                                          <label for="image-upload-3" id="image-label-3" style="cursor:pointer; display:block; text-align:center; line-height:200px;">
                                              Choose File
                                          </label>
                                          <input type="file" name="favicon" id="image-upload-3" class="form-control" style="display:none;">
                                        </div>
                                      
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="image-upload">Breadcrumb</label>
                                        <div id="image-preview-4" class="image-preview" 
                                          style="border: 2px dashed #ccc; width: 200px; height: 200px; display: block; overflow: hidden;">
                                          <label for="image-upload-4" id="image-label-4" style="cursor:pointer; display:block; text-align:center; line-height:200px;">
                                              Choose File
                                          </label>
                                          <input type="file" name="breadcrumb" id="image-upload-4" class="form-control" style="display:none;">
                                        </div>
                                      
                                    </div>
                                  </div>
                                </div>
                                  <button type="submit" class="btn btn-primary">Save</button>
                              </div>
                            </form>
                          </div>



@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {

        function setupImageUpload(inputId, previewId, labelId) {

            const input = document.getElementById(inputId);
            const preview = document.getElementById(previewId);
            const label = document.getElementById(labelId);

            if (!input || !preview || !label) {
                return;
            }

            // Quand l'utilisateur sélectionne une image
            input.addEventListener('change', function (event) {

                const file = event.target.files[0];

                if (!file) {
                    return;
                }

                // Vérification du type
                if (!file.type.startsWith('image/')) {
                    alert('Veuillez sélectionner une image.');
                    input.value = '';
                    return;
                }

                // Affichage du nom
                label.textContent = file.name;

                // Prévisualisation
                const reader = new FileReader();

                reader.onload = function (e) {

                    preview.style.backgroundImage = `url("${e.target.result}")`;
                    preview.style.backgroundSize = 'cover';
                    preview.style.backgroundPosition = 'center';
                    preview.style.backgroundRepeat = 'no-repeat';

                    label.style.background = 'rgba(255, 255, 255, 0.7)';
                };

                reader.readAsDataURL(file);
            });

        }

        setupImageUpload(
            'image-upload',
            'image-preview',
            'image-label'
        );

        setupImageUpload(
            'image-upload-2',
            'image-preview-2',
            'image-label-2'
        );

        setupImageUpload(
            'image-upload-3',
            'image-preview-3',
            'image-label-3'
        );

        setupImageUpload(
            'image-upload-4',
            'image-preview-4',
            'image-label-4'
        );

    });
</script>
@endpush
