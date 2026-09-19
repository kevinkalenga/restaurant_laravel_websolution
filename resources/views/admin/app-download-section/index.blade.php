@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>App Download Section</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('admin.delivery-area.index') }}">Delivery Areas</a></div>
            <div class="breadcrumb-item active">Delivery Area</div>
        </div>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>Update Section</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.app-download.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf

                <div class="form-group">
                   <label>Image</label>
                    <div id="image-preview" class="image-preview">
                      <label for="image-upload" id="image-label">
                          Choose File
                      </label>
                      <input type="file" name="image" id="image-upload" class="form-control" accept="image/*">
                      <input type="hidden" name="old_image" class="form-control" value="">
                    </div>
                 
                </div>
                <div class="form-group">
                    <label>Background</label>

                    <div id="image-preview-2" class="image-preview">
                        <label for="image-upload-2" id="image-label-2">
                            Choose File
                        </label>

                        <input type="file"
                            name="background"
                            id="image-upload-2"
                            class="form-control"
                            accept="image/*">
                         <input type="hidden" name="old_background" class="form-control" value="">
                    </div>
                </div>

                   
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control">
                   
                </div>
                
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="short_description" id="" class="form-control"></textarea>
                   
                </div>

                <div class="form-group">
                    <label>Play Store Link <code>(Leave empty for to hide)</code></label>
                    <input type="text" name="play_store_link" class="form-control">
                   
                </div>
                
                <div class="form-group">
                    <label>Apple Store Link <code>(Leave empty for to hide)</code></label>
                    <input type="text" name="apple_store_link" class="form-control">
                   
                </div>
                

               
                <button type="submit" class="btn btn-primary">Create</button>
                
            </form>
        </div>
    </div>
</section>
@endsection

@push('scripts')


<script>
// document.getElementById('image-upload').addEventListener('change', function (event) {
//     const file = event.target.files[0];

//     if (file) {
//         const preview = document.getElementById('image-preview');

//         preview.style.backgroundImage = `url('${URL.createObjectURL(file)}')`;
//         preview.style.backgroundSize = 'cover';
//         preview.style.backgroundPosition = 'center';

//         document.getElementById('image-label').textContent = 'Change File';
//     }
// });

// document.getElementById('image-upload-2').addEventListener('change', function (event) {
//     const file = event.target.files[0];

//     if (file) {
//         const preview = document.getElementById('image-preview-2');

//         preview.style.backgroundImage = `url('${URL.createObjectURL(file)}')`;
//         preview.style.backgroundSize = 'cover';
//         preview.style.backgroundPosition = 'center';

//         document.getElementById('image-label-2').textContent = 'Change File';
//     }
// });

  $.uploadPreview({
     input_field: "#image-upload",   // Default: .image-upload
     preview_box: "#image-preview",  // Default: .image-preview
     label_field: "#image-label",    // Default: .image-label
     label_default: "Choose File",   // Default: Choose File
     label_selected: "Change File",  // Default: Change File
     no_label: false,                // Default: false
     success_callback: null          // Default: null
  });
  $.uploadPreview({
     input_field: "#image-upload-2",   // Default: .image-upload
     preview_box: "#image-preview-2",  // Default: .image-preview
     label_field: "#image-label-2",    // Default: .image-label
     label_default: "Choose File",   // Default: Choose File
     label_selected: "Change File",  // Default: Change File
     no_label: false,                // Default: false
     success_callback: null          // Default: null
  });
</script>


@endpush



